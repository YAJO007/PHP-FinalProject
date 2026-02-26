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

        if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
            foreach ($_FILES['images']['name'] as $k => $n) {
                if (empty($n) || $_FILES['images']['error'][$k] !== UPLOAD_ERR_OK) continue;

                $tmp = $_FILES['images']['tmp_name'][$k];
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
