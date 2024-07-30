<?php
session_start();

require 'config/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare('SELECT id, password_hash FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: app.php');
            exit();
        } else {
            $_SESSION['error'] = 'Invalid Username or Password!';
            header('Location: index.php');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Please fill in both fields.';
        header('Location: index.php');
        debug_to_console("Login process error ");
        exit();
    }
}
?>