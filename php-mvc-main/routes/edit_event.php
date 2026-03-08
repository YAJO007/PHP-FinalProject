<?php

$m = $_SERVER['REQUEST_METHOD'];

if ($m === 'GET') {
    $eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;

    if ($eid <= 0) {
        renderView('404');
        exit;
    }

    $evt = getEventById($eid);
    if (!$evt) {
        renderView('404');
        exit;
    }

    // Get all images for the event
    $evt['images'] = getImgs($eid);

    renderView('edit_event', ['event' => $evt]);

} elseif ($m === 'POST') {
    global $conn;
    
    $eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Handle delete multiple images (can be combined with update)
    if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
        $images_to_delete = $_POST['delete_images'];
        
        if ($eid > 0 && !empty($images_to_delete)) {
            foreach ($images_to_delete as $image_path) {
                $image_path = basename($image_path); // Security: prevent directory traversal
                $upload_dir = __DIR__ . '/../public/img/';
                $file_path = $upload_dir . $image_path;
                
                // Delete from database
                $sql = "DELETE FROM event_img WHERE eid = ? AND image_path = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("is", $eid, $image_path);
                    $stmt->execute();
                }
                
                // Delete file
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
    }

    // If only deleting images, redirect
    if ($action === 'delete_images' && !isset($_POST['title'])) {
        header('Location: edit_event?eid=' . $eid);
        exit;
    }

    $ttl = isset($_POST['title']) ? trim($_POST['title']) : '';
    $det = isset($_POST['detail']) ? trim($_POST['detail']) : '';
    $sd = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $ed = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $mp = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 0;

    if ($eid <= 0 || empty($ttl) || empty($det) || empty($sd) || empty($ed) || $mp <= 0) {
        header('Location: edit_event?eid=' . $eid . '&error=incomplete');
        exit;
    }

    $sd = str_replace('T', ' ', $sd) . ':00';
    $ed = str_replace('T', ' ', $ed) . ':00';

    $res = updateEvent($eid, $ttl, $mp, $sd, $ed, $det);

    if ($res !== true) {
        header('Location: edit_event?eid=' . $eid . '&err=1');
        exit;
    }

    // DEBUG: Log files
    error_log('DEBUG: FILES received: ' . json_encode([
        'files_keys' => array_keys($_FILES),
        'images_exists' => isset($_FILES['images']),
        'images_names' => isset($_FILES['images']) ? $_FILES['images']['name'] : null,
        'images_errors' => isset($_FILES['images']) ? $_FILES['images']['error'] : null,
    ], JSON_PRETTY_PRINT));

    // Handle multiple image uploads
    if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
        $upload_count = 0;
        foreach ($_FILES['images']['name'] as $k => $n) {
            if (empty($n)) {
                continue;
            }
            
            $error_code = $_FILES['images']['error'][$k];
            if ($error_code !== UPLOAD_ERR_OK) {
                error_log("Upload error for file $n (index $k): " . $error_code);
                continue;
            }

            $tmp = $_FILES['images']['tmp_name'][$k];
            
            // Verify temp file exists
            if (!file_exists($tmp) || !is_uploaded_file($tmp)) {
                error_log("Temp file not valid: $tmp");
                continue;
            }
            
            $ext = strtolower(pathinfo($n, PATHINFO_EXTENSION));
            
            // Validate file extension
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($ext, $allowed_ext)) {
                error_log("Invalid extension: $ext for file $n");
                continue;
            }
            
            // Check file size (5MB max)
            $file_size = $_FILES['images']['size'][$k];
            if ($file_size > 5 * 1024 * 1024) {
                error_log("File too large: $file_size bytes for file $n");
                continue;
            }
            
            $fn = uniqid('event_', true) . '.' . $ext;
            $dir = __DIR__ . '/../public/img/';

            if (!is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            
            $full_path = $dir . $fn;
            if (move_uploaded_file($tmp, $full_path)) {
                error_log("Successfully moved file to: $full_path");
                $add_result = addImg($eid, $fn);
                if ($add_result !== true) {
                    error_log("ERROR: addImg failed with message: " . $add_result);
                } else {
                    error_log("Successfully added image $fn to database for event $eid");
                    $upload_count++;
                }
            } else {
                error_log("Failed to move uploaded file from $tmp to $full_path");
            }
        }
        error_log("Total files uploaded: $upload_count out of " . count($_FILES['images']['name']));
    } else {
        error_log("No files in _FILES or not array. FILES keys: " . implode(',', array_keys($_FILES)));
    }

    header('Location: edit_event?eid=' . $eid . '&success=1');
    exit;
}