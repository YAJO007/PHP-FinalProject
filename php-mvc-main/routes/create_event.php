<?php
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
    $max_participants = 100;
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
        if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

            $tmp_name = $_FILES['image']['tmp_name'];
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_name = uniqid('event_', true) . '.' . $ext;

            $upload_dir = __DIR__ . '/../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            move_uploaded_file($tmp_name, $upload_dir . $new_name);

            addImage($event_id, $new_name); // ✅ ไม่ null แล้ว
        }

        echo "<script>alert('สร้างกิจกรรมสำเร็จ'); location.href='event';</script>";
        exit();
    }

    echo "<script>alert('Error: $res');</script>";
}

renderView('create');
