<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit();
}

$email  = $_SESSION['email'];
$result = getUserByEmail($email);

renderView('profile', ['result' => $result]);