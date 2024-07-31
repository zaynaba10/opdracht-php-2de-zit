<?php
session_start();
require 'config/config.php';
require 'models/Comment.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $content = $_POST['content'];

    try {
        Comment::create($pdo, $task_id, $content);
        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: index.php');
        exit();
    }
}
?>
