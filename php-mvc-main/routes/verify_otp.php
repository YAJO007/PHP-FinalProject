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
$pInfo = null;
$pUid = null;

foreach ($_SESSION as $k => $v) {
    if (strpos($k, "otp_{$eid}_") === 0 && is_array($v)) {
        if ((string)$v['code'] === (string)$otpIn && $v['expires'] > time()) {
            $parts = explode('_', $k);
            $pUid = (int)end($parts);

            if (hasAttended($pUid, $eid)) {
                $_SESSION['checkin_error'] = 'เช็คชื่อแล้ว';
                header('Location: manage_event?eid=' . $eid . '&err=att');
                exit;
            }

            $pInfo = getUserById($pUid);
            $ok = true;
            unset($_SESSION[$k]);
            break;
        }
    }
}

if ($ok && $pInfo && $pUid) {
    markAttended($pUid, $eid);
    $_SESSION['checkin_success'] = [
        'name' => $pInfo['first_name'] . ' ' . $pInfo['last_name'],
        'email' => $pInfo['email'],
        'time' => date('H:i:s')
    ];
    header('Location: manage_event?eid=' . $eid . '&ok=1');
} else {
    header('Location: manage_event?eid=' . $eid . '&err=otp');
}
exit;