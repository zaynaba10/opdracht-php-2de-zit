<?php
session_start();
require 'config/config.php';
require 'models/Task.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $list_id = sanitizeInput(validateInput($_POST['list_id']));
        $name = sanitizeInput(validateInput($_POST['task_name']));
        $deadline = sanitizeInput(validateInput($_POST['deadline']));

        Task::create($pdo, $list_id, $name, $deadline);
        header('Location: app.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = sanitizeInput($e->getMessage());
        header('Location: app.php');
        exit();
    }
}
?>