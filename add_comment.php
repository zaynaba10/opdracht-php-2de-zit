<?php
session_start();
require 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $comment = $_POST['comment'];

    if (empty($comment)) {
        echo 'error: Comment cannot be empty.';
        exit;
    }

    try {
        $stmt = $pdo->prepare('INSERT INTO comments (task_id, comment) VALUES (:task_id, :comment)');
        $stmt->execute(['task_id' => $task_id, 'comment' => $comment]);
        echo 'success';
    } catch (Exception $e) {
        echo 'error: ' . $e->getMessage();
    }
}
?>
