<?php
if (!isset($_SESSION['email'])) {
    header("Location: login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title   = trim($_POST['title'] ?? '');
    $details = trim($_POST['detail'] ?? '');
    $date    = $_POST['date'] ?? '';
    $time    = $_POST['time'] ?? '';
    $category = $_POST['category'] ?? '';
    $creator_email = $_SESSION['email'];

    // กำหนดค่า default
    $max_participants = 100;
    $status = 'open';
    $start_date = $date . ' ' . $time;
    $end_date   = $start_date;

    $res = addEvent(
        $title,
        $max_participants,
        $start_date,
        $end_date,
        $status,
        $category,
        $details,
        $creator_email
    );

    if ($res === true) {

        $event_id = $conn->insert_id;

        // upload รูป
        if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

            $tmp_name = $_FILES['image']['tmp_name'];
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $new_name = uniqid('event_', true) . '.' . $ext;

            $upload_dir = __DIR__ . '/../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            move_uploaded_file($tmp_name, $upload_dir . $new_name);
            addImage($event_id, $new_name);
        }

        echo "<script>alert('สร้างกิจกรรมสำเร็จ'); location.href='event';</script>";
        exit();
    }

    echo "<script>alert('Error: $res');</script>";
}

renderView('create');