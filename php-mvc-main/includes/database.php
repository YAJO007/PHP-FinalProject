<?php

// TEMPORARY: Bypass database for OTP testing
$host = 'localhost';
$db = 'event';
$user = 'root';
$pass = ''; // Change this if you have a password (e.g., 'root', 'password', etc.)

// Try port 3306 first, then 3307
try {
    $conn = @new mysqli($host, $user, $pass, $db, 3306);
    if ($conn->connect_error) {
        $conn = new mysqli($host, $user, $pass, $db, 3307);
    }
} catch (Exception $e) {
    // Create dummy connection for testing
    $conn = new class {
        public $connect_error = null;
        public function query($sql) { 
            return new class {
                public $num_rows = 0;
                public function fetch_assoc() { return null; }
                public function fetch_all() { return []; }
            };
        }
        public function prepare($sql) { 
            return new class {
                public function bind_param($types, ...$params) { return true; }
                public function execute() { return true; }
                public function get_result() { 
                    return new class {
                        public $num_rows = 0;
                        public function fetch_assoc() { return null; }
                        public function fetch_all() { return []; }
                    };
                }
            };
        }
    };
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
require_once DATABASES_DIR . '/address.php';
require_once DATABASES_DIR . '/requirement.php';
require_once DATABASES_DIR . '/user_event.php';