<?php

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
    renderView('404');
    exit;
}

updateEventStatus();
$evt = getEventById($eid);

if (!$evt) {
    renderView('404');
    exit;
}

$addr = getAddr($eid);
if ($addr && $addr->num_rows > 0) {
    $evt['address'] = $addr->fetch_assoc();
} else {
    $evt['address'] = null;
}

$reqs = getReqs($eid);
$reqList = [];
if ($reqs && $reqs->num_rows > 0) {
    while ($row = $reqs->fetch_assoc()) {
        $reqList[] = $row['requirement'];
    }
}
$evt['requirements'] = $reqList;
$evt['images'] = getImgs($eid);

if (empty($evt['images']) && !empty($evt['image_path'])) {
    $evt['images'] = [$evt['image_path']];
}

renderView('detail', ['event' => $evt]);
