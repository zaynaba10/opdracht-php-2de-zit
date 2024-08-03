<?php
require 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // clean and convert POST data
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

    try {
        // get task status
        $checkStmt = $pdo->prepare('SELECT is_done FROM tasks WHERE id = :id');
        $checkStmt->execute(['id' => $id]);
        $task = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($task) {
            // invert value of is done
            $is_done = $task['is_done'] == 1 ? 0 : 1;

            // update met reversed balue
            $stmt = $pdo->prepare('UPDATE tasks SET is_done = :is_done WHERE id = :id');
            $stmt->execute(['is_done' => $is_done, 'id' => $id]);

        } else {
            $_SESSION['error'] = "Task with ID $id does not exist.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}
?>