<?php
// routes/detail_event.php

// คาดว่า index.php จะ include includes/database.php แล้ว ทำให้มีตัวแปร $conn

$eid = isset($_GET['eid']) ? (int)$_GET['eid'] : 0;
if ($eid <= 0) {
	// ถ้าไม่มี id ให้แสดง 404
	renderView('404');
	exit;
}

$event = getEventById($eid);
if (!$event) {
	renderView('404');
	exit;
}

renderView('detail', ['event' => $event]);

?>