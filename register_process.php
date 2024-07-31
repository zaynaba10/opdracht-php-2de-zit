<?php
session_start();

require 'config/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($password) || empty($confirm_password)) {
        die('Please fill in all fields.');
    }

    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    // Check if the username already exists
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Not an available Username or password';
        die('Username already taken.');
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)');
    if ($stmt->execute(['username' => $username, 'password_hash' => $password_hash])) {
                header('Location: index.php');
    } else {
        $_SESSION['error'] = 'An error occurred while registering.';
        die('An error occurred while registering.');
        
    }
}
?>
