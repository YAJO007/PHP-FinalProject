<?php

$sd = $_GET['start_date'] ?? null;
$ed = $_GET['end_date'] ?? null;
$s = $_GET['search'] ?? null;

// Get current user ID to exclude their own events
$current_user_id = isset($_SESSION['email']) ? getUidByEmail($_SESSION['email']) : null;

updateEventStatus();
$res = getEvents($sd, $ed, $s, $current_user_id);

renderView('event', ['result' => $res]);