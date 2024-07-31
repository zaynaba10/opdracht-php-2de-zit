<?php
session_start();
require 'config/config.php'; 
require 'models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    try {
        User::login($pdo, $username, $password);
        
        header('Location: app.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        debug_to_console("error");
        header('Location: index.php');
        exit();
    }
}
?>
