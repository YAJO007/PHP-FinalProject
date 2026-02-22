<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $is_login_success = checklogin($email, $password);

    if ($is_login_success) {
        $_SESSION['email'] = $email;
        header('Location: event');
        exit();
    } else {
        echo "<script>alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง');</script>";
        renderView('login'); 
    }
} else {
    renderView('login');
}
?>