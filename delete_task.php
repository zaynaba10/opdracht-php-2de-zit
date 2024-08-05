<?php
require 'config/config.php';

if (isset($_POST['id'])) {
    $taskId = $_POST['id'];

    // deleted linked comments and then tasks
    $stmt = $pdo->prepare("DELETE FROM comments WHERE task_id = :task_id");
    $stmt->execute(['task_id' => $taskId]);

    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->execute(['id' => $taskId]);


} else {
    $_SESSION['error'] = "could not delete Task.";
}
?>