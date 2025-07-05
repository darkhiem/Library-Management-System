<?php
require_once('config.php');

// Delete books
if (isset($_POST['delete_book'])) {
    $book_id = $_POST['book_id'];
    $conn->query("DELETE FROM borrowed_books WHERE book_id='$book_id'");
    $conn->query("DELETE FROM books WHERE id='$book_id'");
}

// Return book
if (isset($_POST['return_book'])) {
    $borrowed_book_id = $_POST['borrowed_book_id'];
    $book_id = $_POST['book_id'];
    $conn->query("UPDATE borrowed_books SET status = 'returned' WHERE id = '$borrowed_book_id'");
    $conn->query("UPDATE books SET available = TRUE WHERE id = '$book_id'");
    $conn->query("DELETE FROM borrowed_books WHERE id = '$borrowed_book_id'");
}

// Create student
if (isset($_POST['create_student'])) {
    $username = $conn->real_escape_string($_POST['new_username']);
    $email = $conn->real_escape_string($_POST['new_email']);
    $password = $conn->real_escape_string($_POST['new_password']);

    $check_username = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check_username->num_rows > 0) {
        $error_message = "Username already exists. Please choose a different username.";
    } else {
        $conn->query("INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'student')");
    }
}

// Add new book
if (isset($_POST['add_book'])) {
    $title = $conn->real_escape_string($_POST['book_title']);
    $author = $conn->real_escape_string($_POST['book_author']);
    $isbn = $conn->real_escape_string($_POST['book_isbn']);
    $year = $conn->real_escape_string($_POST['book_year']);
    
    $conn->query("INSERT INTO books (title, author, isbn, publication_year) VALUES ('$title', '$author', '$isbn', '$year')");
    $success_message = "Book added successfully!";
}

// Get all students for display
$students = $conn->query("SELECT id, username, email FROM users WHERE role = 'student'");

// Get all books for display
$books = $conn->query("SELECT * FROM books");

// Delete student
if (isset($_POST['delete_student'])) {
    $student_id = $_POST['student_id'];
    $conn->query("DELETE FROM users WHERE id = '$student_id' AND role = 'student'");
}

// Update student
if (isset($_POST['update_student'])) {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $username = $conn->real_escape_string($_POST['edit_username']);
    $email = $conn->real_escape_string($_POST['edit_email']);
    $conn->query("UPDATE users SET username='$username', email='$email' WHERE id='$student_id' AND role='student'");
    $success_message = "Student updated successfully!";
}

// Admin data queries
$books = $conn->query("SELECT * FROM books WHERE available = TRUE");
$admin_borrowed_books = $conn->query("SELECT bb.id AS borrowed_book_id, b.title, bb.due_date, u.username, bb.status, b.id AS book_id FROM borrowed_books bb JOIN books b ON bb.book_id = b.id JOIN users u ON bb.user_id = u.id");
$overdue_books = $conn->query("SELECT b.title, bb.due_date, u.username, DATEDIFF(CURDATE(), bb.due_date) AS overdue_days FROM borrowed_books bb JOIN books b ON bb.book_id = b.id JOIN users u ON bb.user_id = u.id WHERE bb.due_date < CURDATE() AND bb.status = 'borrowed'");
$students = $conn->query("SELECT id, username, email FROM users WHERE role = 'student'");
?>