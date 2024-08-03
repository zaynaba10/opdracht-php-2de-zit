<?php
session_start();
require 'config/config.php';
require 'models/Task.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $list_id = $_POST['list_id'];
    $name = $_POST['task_name'];
    $deadline = $_POST['deadline'];

    try {
        Task::create($pdo, $list_id, $name, $deadline);
        header('Location: app.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: app.php');
        exit();
    }
}
?>