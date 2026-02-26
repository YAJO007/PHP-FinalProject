<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$uid = getUidByEmail($_SESSION['email']);
if (!$uid) {
    $_SESSION['error'] = "ไม่พบผู้ใช้";
    header('Location: login');
    exit;
}

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
    header('Location: my_registrations');
    exit;
}

if (hasAttended($uid, $eid)) {
    if (isset($_GET['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'เช็คชื่อแล้ว']);
    } else {
        $_SESSION['error'] = "เช็คชื่อแล้ว";
        header('Location: my_registrations');
    }
    exit;
}

$sts = getUserRegStatus($uid, $eid);
if ($sts !== 'Approved') {
    $_SESSION['error'] = "ยังไม่ได้อนุมัติ";
    header('Location: my_registrations');
    exit;
}

$otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
$otpKey = "otp_{$eid}_{$uid}";
$_SESSION[$otpKey] = ['code' => $otp, 'expires' => time() + 300];

if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'otp' => $otp, 'expires_in' => 300]);
    exit;
}

$_SESSION['generated_otp'] = $otp;
$_SESSION['otp_eid'] = $eid;
header('Location: my_registrations?otp=1');
