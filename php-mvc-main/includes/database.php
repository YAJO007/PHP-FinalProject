<?php

$hostname = 'k1god.com';
$dbName = 'k1god_comecat';
$username = 'k1god_comecat';
$password = 'qWo3Nqqj~$55mjyG';

$conn = new mysqli($hostname, $username, $password, $dbName, 3306);
if ($conn->connect_error) {
    $conn = new mysqli($hostname, $username, $password, $dbName, 3307);
}

function getConnection(): mysqli
{
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

require_once DATABASES_DIR . '/user.php';
require_once DATABASES_DIR . '/event.php';
require_once DATABASES_DIR . '/event_img.php';
require_once DATABASES_DIR . '/event_otp.php';
require_once DATABASES_DIR . '/address.php';
require_once DATABASES_DIR . '/requirement.php';
require_once DATABASES_DIR . '/user_event.php';