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

// Delete student
if (isset($_POST['delete_student'])) {
    $student_id = $_POST['student_id'];
    $conn->query("DELETE FROM users WHERE id = '$student_id' AND role = 'student'");
}

// AJAX book search
if (isset($_POST['ajax_book_search'])) {
    $book_search = $conn->real_escape_string($_POST['book_search']);
    $result = $conn->query("SELECT id, title, author, publication_year FROM books WHERE available = TRUE AND (title LIKE '%$book_search%' OR author LIKE '%$book_search%' ')");
    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($books);
    exit;
}

// AJAX student search
if (isset($_POST['ajax_student_search'])) {
    $student_search = $conn->real_escape_string($_POST['student_search']);
    $result = $conn->query("SELECT id, username, email FROM users WHERE role = 'student' AND (username LIKE '%$student_search%' OR email LIKE '%$student_search%')");
    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($students);
    exit;
}

/*
// Book search (non-AJAX)
if (isset($_POST['book_search'])) {
    $book_search = $conn->real_escape_string($_POST['book_search']);
    $books = $conn->query("SELECT * FROM books WHERE available = TRUE AND (title LIKE '%$book_search%' OR author LIKE '%$book_search%' OR publication_year LIKE '%$book_search%')");
} else {
    $books = $conn->query("SELECT * FROM books WHERE available = TRUE");
}

// Student search (non-AJAX)
if (isset($_POST['student_search'])) {
    $student_search = $conn->real_escape_string($_POST['student_search']);
    $students = $conn->query("SELECT id, username, email FROM users WHERE role = 'student' AND (username LIKE '%$student_search%' OR email LIKE '%$student_search%')");
} else {
    $students = $conn->query("SELECT id, username, email FROM users WHERE role = 'student'");
}
*/

// Admin data queries
$admin_borrowed_books = $conn->query("SELECT bb.id AS borrowed_book_id, b.title, bb.due_date, u.username, bb.status, b.id AS book_id FROM borrowed_books bb JOIN books b ON bb.book_id = b.id JOIN users u ON bb.user_id = u.id");
$overdue_books = $conn->query("SELECT b.title, bb.due_date, u.username, DATEDIFF(CURDATE(), bb.due_date) AS overdue_days FROM borrowed_books bb JOIN books b ON bb.book_id = b.id JOIN users u ON bb.user_id = u.id WHERE bb.due_date < CURDATE() AND bb.status = 'borrowed'");
?>
