<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    $is_login_success = checklogin($email);

    if ($is_login_success) {
        $_SESSION['email'] = $email;
        header('Location: event');
        exit();
    } else {
        echo "<script>alert('อีเมลไม่ถูกต้อง');</script>";
        renderView('login'); 
    }
} else {
    renderView('login');
}
?>