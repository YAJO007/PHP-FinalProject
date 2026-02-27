<?php

updateEventStatus();
$uid = getUidByEmail($_SESSION['email']);
$res = getEventByUser($uid);

$tot = 0;
$up = 0;
$live = 0;
$done = 0;

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        $tot++;
        switch ($row['status']) {
            case 'Upcoming': $up++; break;
            case 'Live': $live++; break;
            case 'Completed': $done++; break;
        }
    }
    $res->data_seek(0);
}

renderView('my_event', [
    'result' => $res,
    'total' => $tot,
    'upcoming' => $up,
    'ongoing' => $live,
    'finished' => $done]);