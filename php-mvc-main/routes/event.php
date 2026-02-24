<?php

$start_date = $_GET['start_date'] ?? null;
$end_date   = $_GET['end_date'] ?? null;
$search     = $_GET['search'] ?? null;

// เรียกฟังก์ชันเดียวจบ เพราะเราทำ Default Parameter ไว้แล้ว
$result = getEvents($start_date, $end_date, $search);

renderView('event', ['result' => $result]);

