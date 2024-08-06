<?php
session_start();
require 'config/config.php';
require 'models/TaskList.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {
        $name = sanitizeInput(validateInput($_POST['name']));
        $user_id = $_SESSION['user_id'];

        TaskList::create($pdo, $user_id, $name);
        header('Location: app.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = sanitizeInput($e->getMessage());
        header('Location: app.php');
        exit();
    }
}
?>