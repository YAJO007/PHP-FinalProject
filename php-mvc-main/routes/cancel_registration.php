<?php

if (!isset($_SESSION['email'])) {
    header('Location: /login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /my_registrations');
    exit;
}

$eid = $_POST['eid'] ?? null;
if (!$eid) {
    header('Location: /my_registrations');
    exit;
}

$uid = getUidByEmail($_SESSION['email']);
if (!$uid) {
    header('Location: /my_registrations');
    exit;
}

$res = cancelReg($uid, (int)$eid);
if ($res === true) {
    header('Location: /my_registrations');
} else {
    header('Location: /my_registrations?err=' . urlencode($res));
}
exit;
