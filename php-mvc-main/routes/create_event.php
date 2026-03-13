<?php

if (!isset($_SESSION['email'])) {
    header("Location: login");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = getUidByEmail($_SESSION['email']);
    if ($userId === null) {
        die("ไม่พบ user จาก email นี้");
    }
    
    $eventId = addEvent(
        $userId,
        $_POST['title'] ?? '',
        (int)($_POST['max_participants'] ?? 0),
        $_POST['start_date'] ?? '',
        $_POST['end_date'] ?? '',
        'active',
        $_POST['detail'] ?? ''
    );

    if (is_int($eventId)) {
        addAddr($eventId, $_POST['province'], $_POST['district'], $_POST['address']);
        addReq($eventId, $_POST['requirement']);

        $imageDir = __DIR__ . '/../public/img/';
        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0755, true);
        }

        if (!empty($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['cover_image']['tmp_name'];
            $fileName = $_FILES['cover_image']['name'];
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('event_', true) . '.' . $extension;

            if (move_uploaded_file($tmpName, $imageDir . $newFileName)) {
                addImg($eventId, $newFileName);
            }
        }

        if (!empty($_FILES['additional_images']) && is_array($_FILES['additional_images']['name'])) {
            foreach ($_FILES['additional_images']['name'] as $key => $name) {
                if (empty($name) || $_FILES['additional_images']['error'][$key] !== UPLOAD_ERR_OK) {
                    continue;
                }

                $tmpName = $_FILES['additional_images']['tmp_name'][$key];
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $newFileName = uniqid('event_', true) . '.' . $extension;

                if (move_uploaded_file($tmpName, $imageDir . $newFileName)) {
                    addImg($eventId, $newFileName);
                }
            }
        }

        header('Location: event');
        exit;
    }

    echo "<script>alert('Error: $eventId');</script>";
}

renderView('create');
