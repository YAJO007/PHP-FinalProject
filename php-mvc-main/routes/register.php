<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'];
    $fn = $_POST['first_name'];
    $ln = $_POST['last_name'];
    $em = $_POST['email'];
    $pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dob = $_POST['birthdate'];
    $gen = $_POST['gender'];
    $ph = $_POST['phone'];
    $dis = $_POST['congenital'];

    $res = addUser($u, $fn, $ln, $em, $pwd, $dob, $gen, $ph, $dis);

    if ($res === true) {
        header('Location: login');
    } else {
        echo "<script>alert('$res');</script>";
        renderView('register');
    }
} else {
    renderView('register');
}