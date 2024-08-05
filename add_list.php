<?php
session_start();
require 'config/config.php';
require 'models/TaskList.php';

// Function to output JavaScript for debugging
function debugToConsole($message) {
    echo "<script type='text/javascript'>
        console.log('PHP Debug: " . addslashes($message) . "');
    </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $user_id = $_SESSION['user_id'];

    // Debug message to console
    debugToConsole("Attempting to create list");

    try {
        TaskList::create($pdo, $user_id, $name); 
        debugToConsole("Successfully created list");
        header('Location: app.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        debugToConsole("Failed to create list: " . $e->getMessage());
        header('Location: app.php');
        exit();
    }
}
?>
