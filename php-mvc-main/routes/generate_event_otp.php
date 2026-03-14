<?php

header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid event ID']);
    exit;
}

$userId = getUidByEmail($_SESSION['email']);
if (!$userId) {
    echo json_encode(['success' => false, 'error' => 'User not found']);
    exit;
}

if (getUserRegStatus($userId, $eid) !== 'Approved') {
    echo json_encode(['success' => false, 'error' => 'Not approved for this event']);
    exit;
}

if (isUserCheckedIn($userId, $eid)) {
    echo json_encode(['success' => false, 'error' => 'Already checked in']);
    exit;
}

$otpFile = __DIR__ . "/../storage/otp_{$eid}.json";
if (file_exists($otpFile)) {
    $existingOtpData = json_decode(file_get_contents($otpFile), true);
    if ($existingOtpData && $existingOtpData['expires'] > time()) {
        if ($existingOtpData['user_id'] != $userId) {
            echo json_encode(['success' => false, 'error' => 'มีผู้อื่นกำลังใช้งาน OTP สำหรับกิจกรรมนี้แล้ว กรุณารอสักครู่']);
        } else {
            echo json_encode(['success' => false, 'error' => 'มีรหัส OTP ที่ใช้งานอยู่ กรุณารอสักครู่']);
        }
        exit;
    }
}

$otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

$storageDir = __DIR__ . '/../storage';
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0755, true);
}

file_put_contents("{$storageDir}/otp_{$eid}.json", json_encode([
    'code'    => $otp,
    'expires' => time() + 600,
    'user_id' => $userId,
    'event_id' => $eid,
]));

echo json_encode(['success' => true, 'otp' => $otp, 'expires_in' => 600]);
