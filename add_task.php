<?php
session_start();
require 'config/config.php';
require 'models/Task.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $list_id = $_POST['list_id'];
    $title = $_POST['title'];
    $deadline = $_POST['deadline'];

    try {
        Task::create($pdo, $list_id, $title, $deadline);
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: index.php');
        exit();
    }
}
?>
