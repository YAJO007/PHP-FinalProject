<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;

    if ($eid <= 0) {
        $_SESSION['error'] = "ข้อมูลไม่ถูกต้อง";
        header('Location: event');
        exit;
    }

    $uid = getUidByEmail($_SESSION['email']);
    if (!$uid) {
        $_SESSION['error'] = "ไม่พบผู้ใช้";
        header('Location: event');
        exit;
    }

    $res = registerEvent($uid, $eid);
    if ($res === true) {
        $_SESSION['success'] = "ลงทะเบียนสำเร็จ รอการอนุมัติ";
    } else {
        $_SESSION['error'] = $res;
    }

    header('Location: detail?eid=' . $eid);
    exit;
}

header('Location: event');
exit;
