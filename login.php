<?php
session_start();
require 'config/config.php';
require 'models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $user_id = User::login($pdo, $username, $password);
        $_SESSION['user_id'] = $user_id;
        echo 'User ID set in session: ' . $_SESSION['user_id'];
        header('Location: app.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: index.php');
        exit();
    }
}
?>