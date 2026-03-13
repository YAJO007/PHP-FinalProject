<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$eventId = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;

if ($eventId <= 0) {
    header('Location: event');
    exit;
}

$event = getEventById($eventId);
if (!$event) {
    renderView('404');
    exit;
}

$result = deleteEvent($eventId);

if ($result === true) {
    header('Location: my_event?deleted=1');
} else {
    header('Location: detail?eid=' . $eventId . '&err=1');
}
exit;
