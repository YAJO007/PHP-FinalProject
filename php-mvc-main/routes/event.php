<?php

$sd = $_GET['start_date'] ?? null;
$ed = $_GET['end_date'] ?? null;
$s = $_GET['search'] ?? null;

updateEventStatus();
$res = getEvents($sd, $ed, $s);

renderView('event', ['result' => $res]);