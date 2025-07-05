<div class="container">
    <h1>⚙️ Admin Dashboard</h1>

    <!-- Search Section -->
    <div class="search-section">
        <h2>🔍 Search</h2>
        <div class="form-group">
            <input type="text" id="bookSearch" name="book_search" placeholder="Search for books...">
            <button type="button" onclick="ajaxBookSearch()">Search</button>
            <div id="bookSearchResults"></div>
        </div>
        <div class="form-group">
            <input type="text" id="studentSearch" name="student_search" placeholder="Search for students...">
            <button type="button" onclick="ajaxStudentSearch()">Search</button>
            <div id="studentSearchResults"></div>
        </div>
    </div>

    <!-- Manage Students Section -->
    <div class="link" onclick="toggleSection('manage_students')">👥 Manage Students</div>
    <div id="manage_students" class="hidden section-container">
        <h2>Create New Student</h2>
        <?php if (isset($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="POST" onsubmit="return validateStudentForm()">
            <div class="form-group">
                <label for="new_username">Username:</label>
                <input type="text" id="new_username" name="new_username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="new_email">Email:</label>
                <input type="email" id="new_email" name="new_email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="new_password">Password:</label>
                <input type="password" id="new_password" name="new_password" placeholder="Password" required>
            </div>
            <input type="submit" name="create_student" value="Create Student">
        </form>

        <h2>Manage Existing Students</h2>
        <table id="studentsTable">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <?php 
            if ($students->num_rows > 0) {
                while ($student = $students->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $student['id']; ?></td>
                        <?php if (isset($_POST['edit_student_id']) && $_POST['edit_student_id'] == $student['id']): ?>
                            <form method="POST" style="display:inline;">
                                <td><input type="text" name="edit_username" value="<?php echo htmlspecialchars($student['username']); ?>" required></td>
                                <td><input type="email" name="edit_email" value="<?php echo htmlspecialchars($student['email']); ?>" required></td>
                                <td>
                                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                    <input type="submit" name="update_student" value="Save" class="action-btn btn-borrow">
                                    <input type="submit" name="cancel_edit" value="Cancel" class="action-btn btn-return">
                                </td>
                            </form>
                        <?php else: ?>
                            <td><?php echo $student['username']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                    <input type="submit" name="edit_student" value="Edit" class="action-btn btn-edit">
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                                    <input type="submit" name="delete_student" value="Delete" class="action-btn btn-delete">
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile;
            } else { ?>
                <tr><td colspan="4">No students found</td></tr>
            <?php } ?>
        </table>
    </div>

    <!-- All Books List Section -->
    <div class="link" onclick="toggleSection('all_books')">📚 Manage Books</div>
    <div id="all_books" class="hidden section-container">
        <h2>Available Books</h2>
        <table id="booksTable">
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
                while ($book = $books->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $book['id']; ?></td>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo isset($book['author']) ? $book['author'] : 'N/A'; ?></td>
                    <td><?php echo isset($book['isbn']) ? $book['isbn'] : 'N/A'; ?></td>
                    <td><?php echo isset($book['publication_year']) ? $book['publication_year'] : 'N/A'; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                            <input type="submit" name="delete_book" value="Delete" class="action-btn btn-delete">
                        </form>
                    </td>
                </tr>
            <?php 
                endwhile;
            } else { ?>
                <tr><td colspan="6">No books found</td></tr>
            <?php } ?>
        </table>

        <h2>Add New Book</h2>
        <form method="POST">
            <div class="form-group">
                <label for="book_title">Title:</label>
                <input type="text" id="book_title" name="book_title" required>
            </div>
            <div class="form-group">
                <label for="book_author">Author:</label>
                <input type="text" id="book_author" name="book_author" required>
            </div>
            <div class="form-group">
                <label for="book_isbn">ISBN:</label>
                <input type="text" id="book_isbn" name="book_isbn">
            </div>
            <div class="form-group">
                <label for="book_year">Publication Year:</label>
                <input type="number" id="book_year" name="book_year" min="1000" max="<?php echo date('Y'); ?>">
            </div>
            <input type="submit" name="add_book" value="Add Book">
        </form>
    </div>

    <!-- Borrowed Books Section -->
    <div class="link" onclick="toggleSection('borrowed_books')">📖 Borrowed Books</div>
    <div id="borrowed_books" class="section-container">
        <h2>All Borrowed Books</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Due Date</th>
                <th>Student</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php 
            if ($admin_borrowed_books->num_rows > 0) {
                while ($admin_borrowed_book = $admin_borrowed_books->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $admin_borrowed_book['borrowed_book_id']; ?></td>
                        <td><?php echo $admin_borrowed_book['title']; ?></td>
                        <td class="due-date" data-date="<?php echo $admin_borrowed_book['due_date']; ?>">
                            <?php echo $admin_borrowed_book['due_date']; ?>
                        </td>
                        <td><?php echo $admin_borrowed_book['username']; ?></td>
                        <td class="status-indicator">
                            <?php
                            $due_date = new DateTime($admin_borrowed_book['due_date']);
                            $today = new DateTime();
                            $diff = $today->diff($due_date)->format("%r%a");

                            if ($diff < 0) {
                                echo '<span class="status-overdue">Overdue by ' . abs($diff) . ' days</span>';
                            } else {
                                echo '<span class="status-available">' . $diff . ' days remaining</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="borrowed_book_id" value="<?php echo $admin_borrowed_book['borrowed_book_id']; ?>">
                                <input type="hidden" name="book_id" value="<?php echo $admin_borrowed_book['book_id']; ?>">
                                <input type="submit" name="return_book" value="Return Book" class="action-btn btn-return">
                            </form>
                        </td>
                    </tr>
                <?php endwhile;
            } else { ?>
                <tr><td colspan="6">No borrowed books found</td></tr>
            <?php } ?>
        </table>
    </div>

    <!-- Overdue Books Section -->
    <div class="link" onclick="toggleSection('overdue_books')">⚠️ Overdue Books</div>
    <div id="overdue_books" class="hidden section-container">
        <h2>Overdue Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Due Date</th>
                <th>Student</th>
                <th>Days Overdue</th>
                <th>Fine Amount</th>
            </tr>
            <?php 
            if ($overdue_books->num_rows > 0) {
                while ($overdue_book = $overdue_books->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $overdue_book['title']; ?></td>
                        <td><?php echo $overdue_book['due_date']; ?></td>
                        <td><?php echo $overdue_book['username']; ?></td>
                        <td><?php echo $overdue_book['overdue_days']; ?> days</td>
                        <td><?php echo $overdue_book['overdue_days'] * 5; ?> INR</td>
                    </tr>
                <?php endwhile;
            } else { ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No overdue books at this time</td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <!-- Reports Section -->
    <div class="link" onclick="toggleSection('reports')">📊 Reports</div>
    <div id="reports" class="hidden section-container">
        <h2>Library Statistics</h2>

        <?php
        // Get total books count
        $total_books_result = $conn->query("SELECT COUNT(*) as total FROM books");
        $total_books = $total_books_result->fetch_assoc()['total'];

        // Get available books count
        $available_books_result = $conn->query("SELECT COUNT(*) as available FROM books WHERE available = TRUE");
        $available_books = $available_books_result->fetch_assoc()['available'];

        // Get borrowed books count
        $borrowed_books_result = $conn->query("SELECT COUNT(*) as borrowed FROM borrowed_books WHERE status = 'borrowed'");
        $borrowed_books_count = $borrowed_books_result->fetch_assoc()['borrowed'];

        // Get users count
        $users_result = $conn->query("SELECT COUNT(*) as total FROM users WHERE role = 'student'");
        $users_count = $users_result->fetch_assoc()['total'];

        // Get overdue books count
        $overdue_result = $conn->query("SELECT COUNT(*) as overdue FROM borrowed_books WHERE due_date < CURDATE() AND status = 'borrowed'");
        $overdue_count = $overdue_result->fetch_assoc()['overdue'];
        ?>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>📚 Total Books</h3>
                <p><?php echo $total_books; ?></p>
            </div>

            <div class="stat-card">
                <h3>✅ Available Books</h3>
                <p><?php echo $available_books; ?></p>
            </div>

            <div class="stat-card">
                <h3>📖 Borrowed Books</h3>
                <p><?php echo $borrowed_books_count; ?></p>
            </div>

            <div class="stat-card">
                <h3>👥 Total Students</h3>
                <p><?php echo $users_count; ?></p>
            </div>

            <div class="stat-card">
                <h3>⚠️ Overdue Books</h3>
                <p><?php echo $overdue_count; ?></p>
            </div>

            <div class="stat-card">
                <h3>💰 Total Fines</h3>
                <?php
                $fines_result = $conn->query("SELECT SUM(DATEDIFF(CURDATE(), due_date) * 5) as total_fines FROM borrowed_books WHERE due_date < CURDATE() AND status = 'borrowed'");
                $total_fines = $fines_result->fetch_assoc()['total_fines'] ?: 0;
                ?>
                <p><?php echo $total_fines; ?> INR</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize the dashboard
    document.addEventListener('DOMContentLoaded', function() {
        // Show borrowed books section by default
        toggleSection('borrowed_books');
    });

    // AJAX book search function
    function ajaxBookSearch() {
        var query = document.getElementById('bookSearch').value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                var results = JSON.parse(this.responseText);
                var output = '<table><tr><th>ID</th><th>Title</th><th>Author</th><th>Publication Year</th></tr>';
                for (var i = 0; i < results.length; i++) {
                    output += '<tr><td>' + results[i].id + '</td><td>' + results[i].title + '</td><td>' + (results[i].author || 'N/A') + '</td><td>' + (results[i].publication_year || 'N/A') + '</td></tr>';
                }
                output += '</table>';
                document.getElementById('bookSearchResults').innerHTML = output;
            }
        };
        xhr.send('ajax_book_search=1&book_search=' + encodeURIComponent(query));
    }

    // AJAX student search function
    function ajaxStudentSearch() {
        var query = document.getElementById('studentSearch').value;
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (this.status == 200) {
                var results = JSON.parse(this.responseText);
                var output = '<table><tr><th>ID</th><th>Username</th><th>Email</th></tr>';
                for (var i = 0; i < results.length; i++) {
                    output += '<tr><td>' + results[i].id + '</td><td>' + results[i].username + '</td><td>' + results[i].email + '</td></tr>';
                }
                output += '</table>';
                document.getElementById('studentSearchResults').innerHTML = output;
            }
        };
        xhr.send('ajax_student_search=1&student_search=' + encodeURIComponent(query));
    }
</script>