<?php

$result = getEvents();
renderView('event', ['result' => $result]);
