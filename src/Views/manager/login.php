<?php

// Include required files
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../Models/manager/ManagerLoginModel.php';

// Check if there is an error message in the session
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
// Clear the error message after displaying it
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login</title>
    <link rel="stylesheet" href="css\manager\login.css">
</head>
<body>
    <div class="login-container">
        <h2>Manager Login</h2>
        <?php
                 if ($error_message): ?>
                    <div class="error"><?php echo $error_message; ?></div>
                <?php endif; ?>
        <form  method="POST" action="/manager-login">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Enter your username" required name="username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" placeholder="Enter your password" required name="password" >
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>
