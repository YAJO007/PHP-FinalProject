<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $result = getUserByEmail($_SESSION['email']);
    if ($result->num_rows !== 1) {
        renderView('404');
        exit;
    }
    $user = $result->fetch_assoc();
    renderView('edit_profile', ['user' => $user]);

} elseif ($method === 'POST') {
    $email = $_SESSION['email'];
    $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $phone = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $dateOfBirth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $disease = isset($_POST['congenital_disease']) ? trim($_POST['congenital_disease']) : '';

    if (empty($firstName) || empty($lastName) || empty($phone) || empty($dateOfBirth) || empty($gender)) {
        header('Location: edit_profile?err=inv');
        exit;
    }

    $result = updateUser($email, $firstName, $lastName, $phone, $dateOfBirth, $gender, $disease);

    if ($result === true) {
        header('Location: profile?ok=1');
    } else {
        header('Location: edit_profile?err=1');
    }
    exit;
}