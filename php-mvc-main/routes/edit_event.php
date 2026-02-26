<?php

$m = $_SERVER['REQUEST_METHOD'];

if ($m === 'GET') {
    $eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;

    if ($eid <= 0) {
        renderView('404');
        exit;
    }

    $evt = getEventById($eid);
    if (!$evt) {
        renderView('404');
        exit;
    }

    renderView('edit_event', ['event' => $evt]);

} elseif ($m === 'POST') {
    $eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;
    $ttl = isset($_POST['title']) ? trim($_POST['title']) : '';
    $det = isset($_POST['detail']) ? trim($_POST['detail']) : '';
    $sd = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $ed = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $mp = isset($_POST['max_participants']) ? (int)$_POST['max_participants'] : 0;

    if ($eid <= 0 || empty($ttl) || empty($det) || empty($sd) || empty($ed) || $mp <= 0) {
        header('Location: edit_event?eid=' . $eid . '&error=incomplete');
        exit;
    }

    $sd = str_replace('T', ' ', $sd) . ':00';
    $ed = str_replace('T', ' ', $ed) . ':00';

    $res = updateEvent($eid, $ttl, $mp, $sd, $ed, $det);

    if ($res === true) {
        header('Location: detail?eid=' . $eid . '&ok=1');
    } else {
        header('Location: edit_event?eid=' . $eid . '&err=1');
    }
    exit;
}
