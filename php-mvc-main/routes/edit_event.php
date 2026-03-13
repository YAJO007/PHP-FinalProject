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

    // Handle delete cover image
    if (isset($_POST['delete_cover_image']) && !empty($_POST['delete_cover_image'])) {
        $image_to_delete = $_POST['delete_cover_image'];
        $file_path = __DIR__ . '/../public/img/' . $image_to_delete;
        
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        
        // Remove from database
        $stmt = $conn->prepare("DELETE FROM event_img WHERE eid = ? AND image_path = ?");
        $stmt->bind_param("is", $eid, $image_to_delete);
        $stmt->execute();
        $stmt->close();
    }

    // Handle delete additional images
    if (isset($_POST['delete_additional_images']) && is_array($_POST['delete_additional_images'])) {
        foreach ($_POST['delete_additional_images'] as $image_to_delete) {
            if (!empty($image_to_delete)) {
                $file_path = __DIR__ . '/../public/img/' . $image_to_delete;
                
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                
                // Remove from database
                $stmt = $conn->prepare("DELETE FROM event_img WHERE eid = ? AND image_path = ?");
                $stmt->bind_param("is", $eid, $image_to_delete);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    
    // If only deleting images, redirect
    if (($action === 'delete_cover_image' || $action === 'delete_additional_images') && !isset($_POST['title'])) {
        header('Location: edit_event?eid=' . $eid . '&success=1');
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
        'cover_image_exists' => isset($_FILES['cover_image']),
        'cover_image_name' => isset($_FILES['cover_image']) ? $_FILES['cover_image']['name'] : null,
        'cover_image_error' => isset($_FILES['cover_image']) ? $_FILES['cover_image']['error'] : null,
        'cover_image_size' => isset($_FILES['cover_image']) ? $_FILES['cover_image']['size'] : null,
        'additional_images_exists' => isset($_FILES['additional_images']),
        'additional_images_count' => isset($_FILES['additional_images']) ? count($_FILES['additional_images']['name']) : 0,
        'additional_images_errors' => isset($_FILES['additional_images']) ? $_FILES['additional_images']['error'] : null,
        'post_data' => $_POST,
        'eid' => $eid,
    ], JSON_PRETTY_PRINT));

    // Handle cover image upload (single image)
    if (!empty($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES['cover_image']['tmp_name'];
        $name = $_FILES['cover_image']['name'];
        
        if (file_exists($tmp) && is_uploaded_file($tmp)) {
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            
            // Validate file extension
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($ext, $allowed_ext)) {
                // Check file size (5MB max)
                $file_size = $_FILES['cover_image']['size'];
                if ($file_size <= 5 * 1024 * 1024) {
                    $fn = uniqid('event_', true) . '.' . $ext;
                    $dir = __DIR__ . '/../public/img/';

                    if (!is_dir($dir)) {
                        @mkdir($dir, 0755, true);
                    }
                    
                    $full_path = $dir . $fn;
                    if (move_uploaded_file($tmp, $full_path)) {
                        error_log("Successfully moved cover image to: $full_path");
                        $add_result = addImg($eid, $fn);
                        if ($add_result !== true) {
                            error_log("ERROR: addImg failed with message: " . $add_result);
                        } else {
                            error_log("Successfully added cover image $fn to database for event $eid");
                        }
                    } else {
                        error_log("Failed to move uploaded cover image from $tmp to $full_path");
                    }
                } else {
                    error_log("Cover image too large: $file_size bytes for file $name");
                }
            } else {
                error_log("Invalid cover image extension: $ext for file $name");
            }
        }
    }

    // Handle additional images upload (multiple images)
    if (!empty($_FILES['additional_images']) && isset($_FILES['additional_images']['name'])) {
        $file_count = count($_FILES['additional_images']['name']);
        
        for ($i = 0; $i < $file_count; $i++) {
            if ($_FILES['additional_images']['error'][$i] === UPLOAD_ERR_OK) {
                $tmp = $_FILES['additional_images']['tmp_name'][$i];
                $name = $_FILES['additional_images']['name'][$i];
                
                if (file_exists($tmp) && is_uploaded_file($tmp)) {
                    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                    
                    // Validate file extension
                    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
                    if (in_array($ext, $allowed_ext)) {
                        // Check file size (5MB max)
                        $file_size = $_FILES['additional_images']['size'][$i];
                        if ($file_size <= 5 * 1024 * 1024) {
                            $fn = uniqid('event_', true) . '.' . $ext;
                            $dir = __DIR__ . '/../public/img/';

                            if (!is_dir($dir)) {
                                @mkdir($dir, 0755, true);
                            }
                            
                            $full_path = $dir . $fn;
                            if (move_uploaded_file($tmp, $full_path)) {
                                error_log("Successfully moved additional image to: $full_path");
                                $add_result = addImg($eid, $fn);
                                if ($add_result !== true) {
                                    error_log("ERROR: addImg failed with message: " . $add_result);
                                } else {
                                    error_log("Successfully added additional image $fn to database for event $eid");
                                }
                            } else {
                                error_log("Failed to move uploaded additional image from $tmp to $full_path");
                            }
                        } else {
                            error_log("Additional image too large: $file_size bytes for file $name");
                        }
                    } else {
                        error_log("Invalid additional image extension: $ext for file $name");
                    }
                }
            }
        }
    }

    header('Location: edit_event?eid=' . $eid . '&success=1');
    exit;
}