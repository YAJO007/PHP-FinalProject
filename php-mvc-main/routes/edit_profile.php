<?php

if (!isset($_SESSION['email'])) {
    header('Location: login');
    exit;
}

$m = $_SERVER['REQUEST_METHOD'];

if ($m === 'GET') {
    $res = getUserByEmail($_SESSION['email']);
    if ($res->num_rows !== 1) {
        renderView('404');
        exit;
    }
    $u = $res->fetch_assoc();
    renderView('edit_profile', ['user' => $u]);

} elseif ($m === 'POST') {
    $em = $_SESSION['email'];
    $fn = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $ln = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $ph = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : '';
    $dob = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : '';
    $gen = isset($_POST['gender']) ? $_POST['gender'] : '';
    $dis = isset($_POST['congenital_disease']) ? trim($_POST['congenital_disease']) : '';

    if (empty($fn) || empty($ln) || empty($ph) || empty($dob) || empty($gen)) {
        header('Location: edit_profile?err=inv');
        exit;
    }

    $res = updateUser($em, $fn, $ln, $ph, $dob, $gen, $dis);

    if ($res === true) {
        header('Location: profile?ok=1');
    } else {
        header('Location: edit_profile?err=1');
    }
    exit;}