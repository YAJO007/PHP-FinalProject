<?php

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
$act = isset($_GET['action']) ? $_GET['action'] : '';
$uid = isset($_GET['uid']) ? (int)$_GET['uid'] : 0;

if ($eid <= 0) {
    renderView('404');
    exit;
}

$evt = getEventById($eid);
if (!$evt) {
    renderView('404');
    exit;
}

if ($act && $uid > 0) {
    if ($act === 'approve') {
        $res = approveParticipant($eid, $uid);
        if ($res === true) {
            header('Location: manage_event?eid=' . $eid . '&msg=ok');
            exit;
        }
    } elseif ($act === 'reject') {
        $res = rejectParticipant($eid, $uid);
        if ($res === true) {
            header('Location: manage_event?eid=' . $eid . '&msg=rej');
            exit;
        }
    }
}

$pres = getEventParticipants($eid);
$pdata = [];
while ($row = $pres->fetch_assoc()) {
    $pdata[] = $row;
}

$att = getAttendedUsers($eid);
renderView('manage_event', [
    'event' => $evt,
    'participants_data' => $pdata,
    'attended_count' => count($att),
    'attended_users' => $att
]);
