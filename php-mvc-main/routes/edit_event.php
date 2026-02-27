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

    renderView('edit_event', ['event' => $evt]);

} elseif ($m === 'POST') {
    $eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Handle delete image
    if ($action === 'delete_image') {
        if ($eid > 0) {
            $old_path = getImagePath($eid);
            if ($old_path) {
                $upload_dir = __DIR__ . '/../public/img/';
                $file_path = $upload_dir . $old_path;
                
                // Delete from database
                deleteImage($eid);
                
                // Delete file
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
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

    // Handle image upload
    if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        // Validate file extension
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($ext, $allowed_ext)) {
            $new_name = uniqid('event_', true) . '.' . $ext;

            $upload_dir = __DIR__ . '/../public/img/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Get old image path
            $old_image_path = getImagePath($eid);

            // Move new image
            if (move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
                // Update image in database
                $img_result = updateImage($eid, $new_name);

                if ($img_result === true && $old_image_path && file_exists($upload_dir . $old_image_path)) {
                    unlink($upload_dir . $old_image_path);
                }
            } else {
                // Log upload error
                error_log('Upload failed for event ' . $eid . ': ' . $_FILES['image']['error']);
            }
        }
    }

    header('Location: detail?eid=' . $eid . '&ok=1');    exit;
}