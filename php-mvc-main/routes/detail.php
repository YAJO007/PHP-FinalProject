<?php
// routes/detail.php
// Handle /detail?eid=... requests

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
    renderView('404');
    exit;
}

if (!function_exists('getEventById')) {
    require_once DATABASES_DIR . '/event.php';
}

$event = getEventById($eid);
$address = getAddressByEventId($eid);
if ($address && $address->num_rows > 0) {
    $event['address'] = $address->fetch_assoc();
} else {
    $event['address'] = null;
}
$requiredment = getRequirementsByEventId($eid);
if ($requiredment && $requiredment->num_rows > 0) {
    $event['requiredment'] = $requiredment->fetch_assoc();
} else {
    $event['requiredment'] = null;
}
if (!$event) {
    renderView('404');
    exit;
}

// Convert comma-separated images string to array
if (!empty($event['images'])) {
    $event['images'] = explode(',', $event['images']);
} else {
    $event['images'] = [];
}

renderView('detail', ['event' => $event]);

?>
