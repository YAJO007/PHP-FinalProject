<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$eventId = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;

// Handle both old format (single otp field) and new format (otp array)
if (isset($_POST['otp']) && is_array($_POST['otp'])) {
    // New format: otp array from individual input fields
    $otpIn = '';
    foreach ($_POST['otp'] as $digit) {
        $otpIn .= trim($digit);
    }
} else {
    // Old format: single otp field
    $otpIn = isset($_POST['otp']) ? trim($_POST['otp']) : '';
}

if ($eventId <= 0 || empty($otpIn)) {
    header('Location: detail?eid=' . $eventId . '&err=inv');
    exit;
}

$ok = false;

if (verifyEventOtp($eventId, $otpIn)) {
    $ok = true;
} else {
    $otpKey = "event_otp_{$eventId}";
    if (isset($_SESSION[$otpKey])) {
        $storedOtp = $_SESSION[$otpKey]['code'];
        $expires = $_SESSION[$otpKey]['expires'];
        
        if ($storedOtp === $otpIn && $expires > time()) {
            $ok = true;
        }
    }
}

if ($ok) {
    $_SESSION['checkin_success'] = [
        'name' => $_SESSION['email'],
        'email' => $_SESSION['email'],
        'time' => date('H:i:s'),
        'event_id' => $eventId
    ];
    header('Location: detail?eid=' . $eventId . '&checkin=success');
} else {
    header('Location: detail?eid=' . $eventId . '&err=otp');
}
?>
