<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$userId = getUidByEmail($_SESSION['email']);
if (!$userId) {
    $_SESSION['error'] = "ไม่พบผู้ใช้";
    header('Location: login');
    exit;
}

$registrations = [];
$events = getEvents();

if ($events && $events->num_rows > 0) {
    while ($event = $events->fetch_assoc()) {
        if (isUserReg($userId, (int)$event['eid'])) {
            $event['registration_status'] = getUserRegStatus($userId, (int)$event['eid']);
            $event['has_attended'] = hasAttended($userId, (int)$event['eid']);
            $registrations[] = $event;
        }
    }
}

$rejectionHistory = getRejectionHistory($userId);
renderView('my_registrations', [
    'registrations' => $registrations,
    'rejection_history' => $rejectionHistory
]);
