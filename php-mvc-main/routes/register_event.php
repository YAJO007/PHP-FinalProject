<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;

    if ($eventId <= 0) {
        $_SESSION['error'] = "ข้อมูลไม่ถูกต้อง";
        header('Location: event');
        exit;
    }

    $userId = getUidByEmail($_SESSION['email']);
    if (!$userId) {
        $_SESSION['error'] = "ไม่พบผู้ใช้";
        header('Location: event');
        exit;
    }

    $result = registerEvent($userId, $eventId);
    if ($result === true) {
        $_SESSION['success'] = "ลงทะเบียนสำเร็จ รอการอนุมัติ";
    } else {
        $_SESSION['error'] = $result;
    }

    header('Location: detail?eid=' . $eventId);
    exit;
}

header('Location: event');
exit;
