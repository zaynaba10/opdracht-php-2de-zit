<?php
require 'config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $is_done = isset($_POST['is_done']) ? (int)$_POST['is_done'] : 0;

    try {
        $stmt = $pdo->prepare('UPDATE tasks SET is_done = :is_done WHERE id = :id');

        $stmt->execute(['is_done' => $is_done, 'id' => $id]);
        echo $is_done;
    } catch (Exception $e) {
        echo 'error';
    }
}
?>
