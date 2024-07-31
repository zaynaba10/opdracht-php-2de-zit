<?php
session_start();
require 'config/config.php';
require 'models/List.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];

    try {
        List::create($pdo, $name);
        header('Location: app.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: app.php');
        exit();
    }
}
?>
