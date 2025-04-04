<?php
require_once('config.php');

// Logout feature
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Login logic
if (!isset($_SESSION['user'])) {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prevent SQL Injection
        $username = $conn->real_escape_string($username);
        $password = $conn->real_escape_string($password);

        // Query the database for matching user
        $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $_SESSION['user'] = $username;
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['role'] = $user_data['role'];

            header("Location: index.php");
            exit();
        } else {
            $error_message = "Invalid credentials";
        }
    }
}
