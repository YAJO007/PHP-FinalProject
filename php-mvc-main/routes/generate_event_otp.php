<?php

// Debug: Log that the file is being accessed
error_log("generate_event_otp.php accessed");

if (!isset($_SESSION['email'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid event ID: ' . $eid]);
    exit;
}

// Create OTP table if not exists
require_once DATABASES_DIR . '/event_otp.php';
$createResult = createOtpTable();
if ($createResult !== true) {
    error_log("Failed to create OTP table: " . $createResult);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Database error']);
    exit;
}

// Always generate a new OTP (force regeneration)
$otp = str_pad((string)random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

// Save OTP to database (cross-session compatible)
$saveResult = saveEventOtp($eid, $otp, 600); // 10 minutes
if ($saveResult !== true) {
    error_log("Failed to save OTP to database: " . $saveResult);
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Failed to save OTP']);
    exit;
}

// Also keep in session for backup (multiple keys)
$otpData = [
    'code' => $otp, 
    'expires' => time() + 600,
    'created' => time(),
    'forced' => true
];

$keys = [
    "event_otp_{$eid}",
    "otp_event_{$eid}",
    "global_otp_{$eid}",
    "shared_otp_{$eid}"
];

foreach ($keys as $key) {
    $_SESSION[$key] = $otpData;
}

error_log("Generated NEW OTP: $otp for event $eid at " . date('H:i:s') . " (saved to database)");

if (isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'otp' => $otp, 'expires_in' => 600, 'forced' => true, 'source' => 'database']);
    exit;
}

header('Location: manage_event?eid=' . $eid . '&otp_generated=1');
?>
