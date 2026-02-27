<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $em = $_POST['email'];
    $ok = checkLogin($em);

    if ($ok) {
        $_SESSION['email'] = $em;
        header('Location: event');
    } else {
        echo "<script>alert('อีเมลไม่ถูกต้อง');</script>";
        renderView('login');
    }
} else {
    renderView('login');
}