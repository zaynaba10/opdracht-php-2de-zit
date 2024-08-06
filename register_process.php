<?php
session_start();
require 'config/config.php';
require 'models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    try {
        $username = sanitizeInput(validateInput($_POST['username']));
        $password = sanitizeInput(validateInput($_POST['password']));
        $confirm_password = sanitizeInput(validateInput($_POST['confirm_password']));

        User::register($pdo, $username, $password, $confirm_password);
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = sanitizeInput($e->getMessage());
        header('Location: register.php');
        exit();
    }
}
?>