<?php
require_once('config.php');

// Borrowing books
if (isset($_POST['borrow_book'])) {
    $book_id = $_POST['book_id'];
    $user_id = $_SESSION['user_id'];
    $due_date = date('Y-m-d', strtotime('+14 days'));

    // Mark the book as borrowed
    $conn->query("UPDATE books SET available = FALSE WHERE id = '$book_id'");

    // Insert the borrowed book
    $conn->query("INSERT INTO borrowed_books (book_id, user_id, borrow_date, due_date) VALUES ('$book_id', '$user_id', NOW(), '$due_date')");
}

// Fetch available books
$books = $conn->query("SELECT * FROM books WHERE available = TRUE");

// Fetch borrowed books for the logged-in user
if (isset($_SESSION['user_id'])) {
    $borrowed_books = $conn->query("SELECT b.title, bb.borrow_date, bb.due_date, bb.status FROM borrowed_books bb JOIN books b ON bb.book_id = b.id WHERE bb.user_id = " . $_SESSION['user_id']);
}
?>