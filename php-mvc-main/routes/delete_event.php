<?php

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;

if ($eid <= 0) {
    header('Location: event');
    exit;
}

$evt = getEventById($eid);
if (!$evt) {
    renderView('404');
    exit;
}

$res = deleteEvent($eid);

if ($res === true) {
    header('Location: my_event?deleted=1');
} else {
    header('Location: detail?eid=' . $eid . '&err=1');
}
exit;
