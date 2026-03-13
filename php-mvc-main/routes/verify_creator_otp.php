<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
$otpIn = isset($_POST['otp']) ? trim($_POST['otp']) : '';

if ($eid <= 0 || empty($otpIn)) {
    header('Location: manage_event?eid=' . $eid . '&err=inv');
    exit;
}

$ok = false;

if (verifyEventOtp($eid, $otpIn)) {
    $ok = true;
} else {
    $otpKey = "event_otp_{$eid}";
    if (isset($_SESSION[$otpKey])) {
        $storedOtp = $_SESSION[$otpKey]['code'];
        $expires = $_SESSION[$otpKey]['expires'];
        
        if ($storedOtp === $otpIn && $expires > time()) {
            $ok = true;
        }
    }
}

if ($ok) {
    $_SESSION['creator_verified'] = [
        'name' => $_SESSION['email'],
        'email' => $_SESSION['email'],
        'time' => date('H:i:s'),
        'event_id' => $eid
    ];
    header('Location: manage_event?eid=' . $eid . '&verified=success');
} else {
    header('Location: manage_event?eid=' . $eid . '&err=otp');
}
?>
