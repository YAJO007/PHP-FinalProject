<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$eventId = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';
$userId = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;

if ($eventId <= 0) {
    renderView('404');
    exit;
}

$event = getEventById($eventId);
if (!$event) {
    renderView('404');
    exit;
}

if ($action && $userId > 0) {
    if ($action === 'approve') {
        $result = approveParticipant($eventId, $userId);
        if ($result === true) {
            header('Location: manage_event?eid=' . $eventId . '&msg=ok');
            exit;
        }
    } elseif ($action === 'reject') {
        $result = rejectParticipant($eventId, $userId);
        if ($result === true) {
            header('Location: manage_event?eid=' . $eventId . '&msg=rej');
            exit;
        }
    }
}

$participants = getEventParticipants($eventId);
$participantsData = [];
while ($row = $participants->fetch_assoc()) {
    $participantsData[] = $row;
}

$attendedUsers = getAttendedUsers($eventId);
renderView('manage_event', [
    'event' => $event,
    'participants_data' => $participantsData,
    'attended_count' => count($attendedUsers),
    'attended_users' => $attendedUsers
]);
