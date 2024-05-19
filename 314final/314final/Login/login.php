<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Real Estate System</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <div class="image-section">
            <img src="../logo.jpg" alt="Real Estate">
        </div>
        <div class="form-section">
            <header>
                <h1>Login to Real Estate System</h1>
            </header>
            <main>
                <?php
                if (isset($_GET['error']) && $_GET['error'] == 1) {
                    echo '<p class="error-message">Invalid username or password. Please try again.</p>';
                }
                ?>
                <form action="LoginController.php" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <input type="submit" value="Login">
                </form>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </main>
            <footer>
                &copy; <?php echo date("Y"); ?> Real Estate System
            </footer>
        </div>
    </div>
</body>
</html>
