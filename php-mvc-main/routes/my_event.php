<?php

$user_id = getUseridbyEmail($_SESSION['email']);
$events = getMyEvents($user_id);
renderView('my_event', ['events' => $events]);
