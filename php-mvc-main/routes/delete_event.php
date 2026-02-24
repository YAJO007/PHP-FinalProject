<?php
// routes/delete_event.php - Handle event deletion

// Ensure functions are loaded
if (!function_exists('deleteEvent')) {
    require_once DATABASES_DIR . '/event.php';
}

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;

if ($eid <= 0) {
    header('Location: event');
    exit;
}

// Verify event exists
if (!function_exists('getEventById')) {
    require_once DATABASES_DIR . '/event.php';
}

$event = getEventById($eid);
if (!$event) {
    renderView('404');
    exit;
}

// Delete the event
$result = deleteEvent($eid);

if ($result === true) {
    // Success - redirect to events list
    header('Location: my_event?deleted=success');
    exit;
} else {
    // Error - redirect back with error message
    header('Location: detail?eid=' . $eid . '&error=delete_failed');
    exit;
}

?>
