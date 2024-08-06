<?php
$host = 'localhost';
$db = 'todo_app';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}


function sanitizeInput($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}


function validateInput($input, $maxLength = 255)
{
    $input = trim($input);
    if (strlen($input) > $maxLength) {
        throw new Exception("Input exceeds maximum length of $maxLength characters.");
    }
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $input)) {
        throw new Exception("Input contains invalid characters. Only letters, numbers, and spaces are allowed.");
    }
    return $input;
}


function executeQuery($pdo, $query, $params)
{
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt;
}
?>