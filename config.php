<?php
// Database connection
$host = 'localhost';
$db = 'library';
$user = 'root';  // Change to your MySQL username
$pass = 'daksh@1234';      // Change to your MySQL password (leave empty if no password)

$conn = new mysqli($host, $user, $pass, $db, 3306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
