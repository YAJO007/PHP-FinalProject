<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$res = getUserByEmail($_SESSION['email']);
renderView('profile', ['result' => $res]);