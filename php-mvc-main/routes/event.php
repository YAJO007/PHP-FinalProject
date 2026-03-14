<?php

$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;
$search = $_GET['search'] ?? null;

// Get current user ID to exclude their own events
$currentUserId = isset($_SESSION['email']) ? getUidByEmail($_SESSION['email']) : null;

updateEventStatus();
$events = getEvents($startDate, $endDate, $search, $currentUserId);

renderView('event', ['result' => $events]);