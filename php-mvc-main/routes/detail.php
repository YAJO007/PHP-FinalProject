<?php
// routes/detail.php
// Handle /detail?eid=... requests

require_once DATABASES_DIR . '/event.php';
require_once DATABASES_DIR . '/event_img.php';

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
    renderView('404');
    exit;
}

if (!function_exists('getEventById')) {
    require_once DATABASES_DIR . '/event.php';
}

updateEventStatus();

$event = getEventById($eid);
$address = getAddressByEventId($eid);
if ($address && $address->num_rows > 0) {
    $event['address'] = $address->fetch_assoc();
} else {
    $event['address'] = null;
}
$requiredment = getRequirementsByEventId($eid);
if ($requiredment && $requiredment->num_rows > 0) {
    $requirements_list = [];
    while ($row = $requiredment->fetch_assoc()) {
        $requirements_list[] = $row['requirement'];
    }
    $event['requirements'] = $requirements_list;
} else {
    $event['requirements'] = [];
}

// Get all event images
$event['images'] = getEventImages($eid);

// If no images found, try to get the single image from event table
if (empty($event['images']) && !empty($event['image_path'])) {
    $event['images'] = [$event['image_path']];
}

// Debug: Log image data (remove in production)
error_log('Event ID: ' . $eid . ' - Images found: ' . json_encode($event['images']));

if (!$event) {
    renderView('404');
    exit;
}

renderView('detail', ['event' => $event]);

?>
