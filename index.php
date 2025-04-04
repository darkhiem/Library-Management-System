<?php
require_once('config.php');
require_once('auth.php');

// Include role-specific logic if user is logged in
if (isset($_SESSION['user'])) {
    if ($_SESSION['role'] === 'student') {
        require_once('student.php');
    } else if ($_SESSION['role'] === 'admin') {
        require_once('admin.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>

<body>

    <?php if (isset($_SESSION['user'])): ?>
        <!-- Show User Information -->
        <div class="container">
            <p>Welcome, <?php echo $_SESSION['user']; ?> (<?php echo ucfirst($_SESSION['role']); ?>)</p>
            <form method="POST" style="text-align: right;">
                <input type="submit" name="logout" value="Logout" style="background-color: red; color: white; padding: 10px; border-radius: 5px;">
            </form>
        </div>

        <?php if ($_SESSION['role'] === 'student'): ?>
            <?php include('student_dashboard.php'); ?>
        <?php elseif ($_SESSION['role'] === 'admin'): ?>
            <?php include('admin_dashboard.php'); ?>
        <?php endif; ?>
    <?php else: ?>
        <?php include('login_form.php'); ?>
    <?php endif; ?>

</body>

</html>