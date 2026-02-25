<?php
require_once DATABASES_DIR . '/event.php';
require_once DATABASES_DIR . '/event_img.php';

if (!isset($_SESSION['email'])) {
    header("Location: login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = getUseridbyEmail($_SESSION['email']);

    if ($user_id === null) {
        die("ไม่พบ user จาก email นี้");
    }
    $title   = $_POST['title'] ?? '';
    $details = $_POST['detail'] ?? '';
    $creator_email = $_SESSION['email'];
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $max_participants = $_POST['max_participants'] ?? '';
    $status = 'active';
    $create_at = date('Y-m-d');
    $res = addEvent(
        $user_id,
        $title,
        $max_participants,
        $start_date,
        $end_date,
        $status,
        $details,
        $create_at
    );

    if (is_int($res)) {

        $event_id = $res;
        addAddress($event_id, $_POST['province'], $_POST['district'], $_POST['address']);
        addRequirement($event_id, $_POST['requirement']);
        // Handle multiple images
        $uploaded_images = [];
        if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
            foreach ($_FILES['images']['name'] as $key => $name) {
                if (!empty($name) && $_FILES['images']['error'][$key] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['images']['tmp_name'][$key];
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    $new_name = uniqid('event_', true) . '.' . $ext;

                    $upload_dir = __DIR__ . '/../public/img/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }

                    if (move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
                        $uploaded_images[] = $new_name;
                        addImage($event_id, $new_name);
                    }
                }
            }
        }

        echo "<script>alert('สร้างกิจกรรมสำเร็จ'); location.href='event';</script>";
        exit();
    }

    echo "<script>alert('Error: $res');</script>";
}

renderView('create');
