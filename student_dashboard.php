<div class="container">
    <h1>Student Dashboard</h1>
    <h2>Available Books</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Action</th>
        </tr>
        <?php while ($book = $books->fetch_assoc()): ?>
            <tr>
                <td><?php echo $book['title']; ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                        <input type="submit" name="borrow_book" value="Borrow">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Borrowed Books</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Borrow Date</th>
            <th>Due Date</th>
        </tr>
        <?php while ($borrowed_book = $borrowed_books->fetch_assoc()): ?>
            <tr>
                <td><?php echo $borrowed_book['title']; ?></td>
                <td><?php echo $borrowed_book['borrow_date']; ?></td>
                <td><?php echo $borrowed_book['due_date']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>