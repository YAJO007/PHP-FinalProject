<?php

if (!isset($_SESSION['email'])) {
    header("Location: login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = getUidByEmail($_SESSION['email']);
    if ($uid === null) {
        die("ไม่พบ user จาก email นี้");
    }
    
    $eid = addEvent(
        $uid,
        $_POST['title'] ?? '',
        (int)($_POST['max_participants'] ?? 0),
        $_POST['start_date'] ?? '',
        $_POST['end_date'] ?? '',
        'active',
        $_POST['detail'] ?? ''
    );

    if (is_int($eid)) {
        addAddr($eid, $_POST['province'], $_POST['district'], $_POST['address']);
        addReq($eid, $_POST['requirement']);

        // Handle cover image (single image - will be first in array)
        if (!empty($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $tmp = $_FILES['cover_image']['tmp_name'];
            $name = $_FILES['cover_image']['name'];
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $fn = uniqid('event_', true) . '.' . $ext;
            $dir = __DIR__ . '/../public/img/';

            if (!is_dir($dir)) mkdir($dir, 0755, true);
            if (move_uploaded_file($tmp, $dir . $fn)) {
                addImg($eid, $fn);
            }
        }

        // Handle additional images (multiple images)
        if (!empty($_FILES['additional_images']) && is_array($_FILES['additional_images']['name'])) {
            foreach ($_FILES['additional_images']['name'] as $k => $n) {
                if (empty($n) || $_FILES['additional_images']['error'][$k] !== UPLOAD_ERR_OK) continue;

                $tmp = $_FILES['additional_images']['tmp_name'][$k];
                $ext = pathinfo($n, PATHINFO_EXTENSION);
                $fn = uniqid('event_', true) . '.' . $ext;
                $dir = __DIR__ . '/../public/img/';

                if (!is_dir($dir)) mkdir($dir, 0755, true);
                if (move_uploaded_file($tmp, $dir . $fn)) {
                    addImg($eid, $fn);
                }
            }
        }

        echo "<script>alert('สร้างกิจกรรมสำเร็จ'); location.href='event';</script>";
        exit;
    }

    echo "<script>alert('Error: $eid');</script>";
}

renderView('create');
