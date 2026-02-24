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
