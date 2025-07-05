<div class="container">
    <h1>🎓 Student Dashboard</h1>
    <h2>Available Books</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Publication Year</th>
            <th>Action</th>
        </tr>
        <?php
        if ($books->num_rows > 0) {
            while ($book = $books->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $book['id']; ?></td>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo isset($book['author']) ? $book['author'] : 'N/A'; ?></td>
                    <td><?php echo isset($book['isbn']) ? $book['isbn'] : 'N/A'; ?></td>
                    <td><?php echo isset($book['publication_year']) ? $book['publication_year'] : 'N/A'; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <input type="submit" name="borrow_book" value="Borrow" class="action-btn btn-borrow">
                        </form>
                    </td>
                </tr>
            <?php endwhile;
        } else { ?>
            <tr>
                <td colspan="6">No books available</td>
            </tr>
        <?php } ?>
    </table>

    <h2>My Borrowed Books</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Borrow Date</th>
            <th>Due Date</th>
            <th>Status</th>
        </tr>
        <?php
        if ($borrowed_books->num_rows > 0) {
            while ($borrowed_book = $borrowed_books->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $borrowed_book['title']; ?></td>
                    <td><?php echo $borrowed_book['borrow_date']; ?></td>
                    <td><?php echo $borrowed_book['due_date']; ?></td>
                    <td>
                        <?php
                        $due_date = new DateTime($borrowed_book['due_date']);
                        $today = new DateTime();
                        $diff = $today->diff($due_date)->format("%r%a");

                        if ($diff < 0) {
                            echo '<span class="status-overdue">Overdue by ' . abs($diff) . ' days</span>';
                        } else {
                            echo '<span class="status-available">' . $diff . ' days remaining</span>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile;
        } else { ?>
            <tr>
                <td colspan="4">No borrowed books</td>
            </tr>
        <?php } ?>
    </table>
</div>