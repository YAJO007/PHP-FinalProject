<?php

$hostname = 'localhost';
$dbName = 'event';
$username = 'root';
$password = '';
$conn = new mysqli($hostname, $username, $password, $dbName);

function getConnection(): mysqli
{
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// database functions ต่างๆ
require_once DATABASES_DIR . '/user.php';
require_once DATABASES_DIR . '/event.php';
require_once DATABASES_DIR . '/event_img.php';
require_once DATABASES_DIR . '/address.php';
require_once DATABASES_DIR . '/requirement.php';
require_once DATABASES_DIR . '/user_event.php';
<<<<<<< HEAD
=======

>>>>>>> Duckydoo
