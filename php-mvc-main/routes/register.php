<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $congenital = $_POST['congenital'];

    $result = addUser($username, $firstName, $lastName, $email, $password, $birthdate, $gender, $phone, $congenital);

    if ($result === true) {
        header('Location: login');
        exit;
    } else {
        renderView('register', ['error' => $result]);
    }
} else {
    renderView('register');
}