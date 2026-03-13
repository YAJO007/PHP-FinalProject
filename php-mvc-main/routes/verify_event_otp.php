<?php

// Debug: Log verification attempt
error_log("verify_event_otp.php accessed");

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
$otpIn = isset($_POST['otp']) ? trim($_POST['otp']) : '';

error_log("Verification attempt - Event ID: $eid, OTP: $otpIn");

if ($eid <= 0 || empty($otpIn)) {
    header('Location: detail?eid=' . $eid . '&err=inv');
    exit;
}

$ok = false;

// Try database first (cross-session compatible)
require_once DATABASES_DIR . '/event_otp.php';
if (function_exists('verifyEventOtp')) {
    if (verifyEventOtp($eid, $otpIn)) {
        $ok = true;
        error_log("OTP verification SUCCESS via database");
    } else {
        error_log("Database verification failed, trying session...");
    }
}

// If database failed, try session as backup
if (!$ok) {
    $possibleKeys = [
        "event_otp_{$eid}",      // New system
        "otp_event_{$eid}",      // Old system
        "global_otp_{$eid}",     // Cross-session
        "shared_otp_{$eid}",     // Cross-session
    ];

    error_log("Looking for OTP keys: " . implode(', ', $possibleKeys));
    error_log("Current session keys: " . implode(', ', array_keys($_SESSION)));

    foreach ($possibleKeys as $otpKey) {
        if (isset($_SESSION[$otpKey]) && is_array($_SESSION[$otpKey])) {
            $storedOtp = $_SESSION[$otpKey]['code'];
            $expires = $_SESSION[$otpKey]['expires'];
            $currentTime = time();
            
            error_log("Checking key $otpKey - Stored: $storedOtp, Input: $otpIn, Expires: $expires, Current: $currentTime");
            
            if ((string)$storedOtp === (string)$otpIn && $expires > $currentTime) {
                $ok = true;
                error_log("OTP verification SUCCESS with session key: $otpKey");
                break;
            }
        }
    }
}

if (!$ok) {
    error_log("OTP verification FAILED - No valid OTP found in database or session");
}

if ($ok) {
    $_SESSION['checkin_success'] = [
        'name' => $_SESSION['email'],
        'email' => $_SESSION['email'],
        'time' => date('H:i:s'),
        'event_id' => $eid
    ];
    header('Location: detail?eid=' . $eid . '&checkin=success');
} else {
    header('Location: detail?eid=' . $eid . '&err=otp');
}
exit;
?>
