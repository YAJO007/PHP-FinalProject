<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $congenital = $_POST['congenital'];
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $result = addStudent($username, $first_name, $last_name, $email, $hashed_password, $birthdate, $gender, $phone, $congenital);
    
    if ($result === true) {
        header('Location: login');
        exit();
    } else {
        $error_message = $result;
        echo "<script>alert('$error_message');</script>";
        renderView('register'); 
    }

} else {
    renderView('register');
}
?>