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

$regs = [];
$evts = getEvents();

if ($evts && $evts->num_rows > 0) {
    while ($e = $evts->fetch_assoc()) {
        if (isUserReg($uid, (int)$e['eid'])) {
            $e['registration_status'] = getUserRegStatus($uid, (int)$e['eid']);
            $e['has_attended'] = hasAttended($uid, (int)$e['eid']);
            $regs[] = $e;
        }
    }
}

$rejHist = getRejectionHistory($uid);
renderView('my_registrations', [
    'registrations' => $regs,
    'rejection_history' => $rejHist
]);
