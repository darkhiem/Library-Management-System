<div class="container">
    <h1>Login</h1>
    <?php if (isset($error_message)): ?>
        <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="login" value="Login">
    </form>
</div>