<?php

if (!isset($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid event ID']);
    exit;
}

$otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
$saveResult = saveEventOtp($eid, $otp, 600);

if ($saveResult !== true) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Failed to save OTP']);
    exit;
}

$_SESSION["event_otp_{$eid}"] = [
    'code' => $otp,
    'expires' => time() + 600,
    'created' => time()
];

if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'otp' => $otp, 'expires_in' => 600]);
    exit;
}

header('Location: manage_event?eid=' . $eid . '&otp_generated=1');
?>
