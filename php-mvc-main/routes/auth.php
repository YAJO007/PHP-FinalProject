<?php

require_once "../includes/database.php";
require_once "../includes/view.php";
session_start();

$action = $_POST['action'] ?? 'login';

if ($action === 'login') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /");
            exit;
        }

        $error = "Invalid credentials";
    }

    renderView("login", ['error' => $error ?? null]);
}

if ($action === 'register') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (name,email,password) VALUES (?,?,?)");
        $stmt->execute([$name,$email,$password]);

        header("Location: /?route=auth&action=login");
        exit;
    }

    renderView("register");
}
