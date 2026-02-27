<?php

updateEventStatus();
$res = getEvents();
renderView('home', ['title' => 'Events', 'result' => $res]);