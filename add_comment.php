<?php
session_start();
require 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $task_id = sanitizeInput(validateInput($_POST['task_id']));
        $comment = sanitizeInput(validateInput($_POST['comment']));

        Comment::create($pdo, $task_id, $comment);
        header('Location: app.php');
        exit();
    } catch (Exception $e) {

        $_SESSION['error'] = sanitizeInput($e->getMessage());
    }
}
?>