<?php
// routes/manage_event.php - Manage event participants and statistics

// Ensure functions are loaded
if (!function_exists('getEventById')) {
    require_once DATABASES_DIR . '/event.php';
}

if (!function_exists('getEventParticipants')) {
    require_once DATABASES_DIR . '/event.php';
}

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';
$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;

// Validate event ID
if ($eid <= 0) {
    renderView('404');
    exit;
}

// Get event details
$event = getEventById($eid);
if (!$event) {
    renderView('404');
    exit;
}

// Handle approve/reject actions
if ($action && $uid > 0) {
    if ($action === 'approve') {
        $result = approveParticipant($eid, $uid);
        if ($result === true) {
            header('Location: manage_event?eid=' . $eid . '&message=approved');
            exit;
        }
    } elseif ($action === 'reject') {
        $result = rejectParticipant($eid, $uid);
        if ($result === true) {
            header('Location: manage_event?eid=' . $eid . '&message=rejected');
            exit;
        }
    }
}

// Get participants list
$participants_result = getEventParticipants($eid);
$participants_data = [];
while ($row = $participants_result->fetch_assoc()) {
    $participants_data[] = $row;
}

// Render the manage event template
renderView('manage_event', [
    'event' => $event,
    'participants_data' => $participants_data
]);

?>
