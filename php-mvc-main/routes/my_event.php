<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

updateEventStatus();
$userId = getUidByEmail($_SESSION['email']);
$events = getEventByUser($userId);

$total = 0;
$upcoming = 0;
$live = 0;
$completed = 0;

if ($events && $events->num_rows > 0) {
    while ($row = $events->fetch_assoc()) {
        $total++;
        switch ($row['status']) {
            case 'Upcoming': $upcoming++; break;
            case 'Live': $live++; break;
            case 'Completed': $completed++; break;
        }
    }
    $events->data_seek(0);
}

renderView('my_event', [
    'result' => $events,
    'total' => $total,
    'upcoming' => $upcoming,
    'ongoing' => $live,
    'finished' => $completed
]);