<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$eid   = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
$otpIn = isset($_POST['otp']) ? trim($_POST['otp']) : '';

if ($eid <= 0 || empty($otpIn)) {
    header("Location: manage_event?eid={$eid}&err=inv");
    exit;
}

// Load OTP from file (written by participant's session)
$otpFile = __DIR__ . "/../storage/otp_{$eid}.json";

if (!file_exists($otpFile)) {
    header("Location: manage_event?eid={$eid}&err=otp");
    exit;
}

$otpData = json_decode(file_get_contents($otpFile), true);

// Validate: must exist, not expired, and code must match
if (!$otpData || $otpData['expires'] <= time() || $otpData['code'] !== $otpIn) {
    if ($otpData && $otpData['expires'] <= time()) {
        unlink($otpFile); // clean up expired file
    }
    header("Location: manage_event?eid={$eid}&err=otp");
    exit;
}

// Record attendance for the participant who generated the OTP
$participantId = (int)($otpData['user_id'] ?? 0);
if (!recordAttendance($eid, $participantId, $otpIn)) {
    header("Location: manage_event?eid={$eid}&err=attendance_failed");
    exit;
}

// Clear OTP file after successful check-in
unlink($otpFile);

$_SESSION['participant_verified'] = [
    'time'     => date('H:i:s'),
    'event_id' => $eid,
];

header("Location: manage_event?eid={$eid}&verified=success");
