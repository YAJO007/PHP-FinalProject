<?php

$eventId = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eventId <= 0) {
    renderView('404');
    exit;
}

updateEventStatus();
$event = getEventById($eventId);

if (!$event) {
    renderView('404');
    exit;
}

$address = getAddr($eventId);
if ($address && $address->num_rows > 0) {
    $event['address'] = $address->fetch_assoc();
} else {
    $event['address'] = null;
}

$requirements = getReqs($eventId);
$requirementList = [];
if ($requirements && $requirements->num_rows > 0) {
    while ($row = $requirements->fetch_assoc()) {
        $requirementList[] = $row['requirement'];
    }
}
$event['requirements'] = $requirementList;
$event['images'] = getImgs($eventId);

if (empty($event['images']) && !empty($event['image_path'])) {
    $event['images'] = [$event['image_path']];
}

renderView('detail', ['event' => $event]);
