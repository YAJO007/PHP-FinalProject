<?php
// ประมวลผลก่อนแสดงผลหน้า
updateEventStatus();

// เรียกฟังก์ชันเดียวจบ เพราะเราทำ Default Parameter ไว้แล้ว
$result = getEvents();

renderView('home', ['title' => 'Welcome to Home Page', 'result' => $result]);