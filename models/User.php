<?php

class User {
    private $id;
    private $username;
    private $password;
    private $email;
    private $created_at;

    // Getters and Setters
    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }


    public function getCreatedAt() {
        return $this->created_at;
    }

    public static function register($pdo, $username, $password, $confirm_password) {
        if (empty($username) || empty($password) || empty($confirm_password)) {
            throw new Exception('Please fill in all fields.');
        }

        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match.');
        }

        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        if ($stmt->fetch()) {
            throw new Exception('Username already taken.');
        }

        // Hash the password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare('INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)');
        if (!$stmt->execute(['username' => $username, 'password_hash' => $password_hash])) {
            throw new Exception('An error occurred while registering.');
        }

        return true;
    }

    public static function login($pdo, $username, $password) {
    if (empty($username) || empty($password)) {
        throw new Exception('Please fill in all fields.');
    }

    // Retrieve the user data from the database
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        // Set user session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    } else {
        throw new Exception('Invalid username or password.');
    }
    }

    // Constructor
    public function __construct($username = null, $password = null, $email = null) {
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setEmail($email);
    }
}
?>
