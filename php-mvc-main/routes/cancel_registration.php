<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: my_registrations');
    exit;
}

$eventId = $_POST['eid'] ?? null;
if (!$eventId) {
    header('Location: my_registrations');
    exit;
}

$userId = getUidByEmail($_SESSION['email']);
if (!$userId) {
    header('Location: my_registrations');
    exit;
}

$result = cancelReg($userId, (int)$eventId);
if ($result === true) {
    header('Location: my_registrations');
} else {
    header('Location: my_registrations?err=' . urlencode($result));
}
exit;
