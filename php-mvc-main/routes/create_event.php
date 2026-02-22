<?php

if (!isset($_SESSION['email'])) {
    header("Location: login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title'] ?? '');
    $detail = trim($_POST['detail'] ?? '');
    $date = $_POST['date'] ?? null;
    $time = $_POST['time'] ?? null;
    $location = trim($_POST['location'] ?? '');
    $category = $_POST['category'] ?? '';
    $creator = $_SESSION['email'];

    $res = addEvent($title,
    $max_participants,
    $start_date,
    $end_date,
    $status,
    $category,
    $details,
    $creator_email);

    if ($res === true) {
        echo "<script>alert('สร้างกิจกรรมสำเร็จ'); location.href='event';</script>";
        exit();
    } else {
        echo "<script>alert('Error: $res');</script>";
    }
}

// ต้องอยู่นอก if
renderView('create');