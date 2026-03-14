<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    if (checkLogin($email)) {
        $_SESSION['email'] = $email;
        header('Location: event');
        exit;
    } else {
        renderView('login', ['error' => 'อีเมลไม่ถูกต้อง']);
    }
} else {
    renderView('login');
}