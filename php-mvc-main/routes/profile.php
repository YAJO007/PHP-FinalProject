<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$user = getUserByEmail($_SESSION['email']);
renderView('profile', ['result' => $user]);