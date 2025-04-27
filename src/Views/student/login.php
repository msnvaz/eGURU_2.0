<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Guru Login</title>
    <link rel="stylesheet" href="/css/student/login.css">
    <link rel="stylesheet" href="/css/footer.css">
    <style>
    nav {
        position: fixed;
        top: 0;
        min-width: 100%;
        z-index: 1000;
        background-color: #ffffff;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        padding-left: 20px;
        margin-left: 20px;
        margin-right: -20px;
    }
    
    .navbar-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 10px 5px;
        padding-left: 0;
        padding-right:40px;
    }

    .nav-link {
        display: block;
        text-decoration: none;
        color: var(--dark-blue);
        font-weight: 500;
        font-size: 15px;
        padding: 5px 5px;
        border-radius: 5px;
        transition: all 0.3s ease;
        position: relative;
    }
    </style>
</head>
<body>
<?php include '../src/Views/navbar.php'; ?> <!-- Include the navbar -->    

    <main>
        
    <div class="login-container">

    <h1>Welcome to e-Guru</h1>

    <form method="post" action="/student-login">
        <label for="email">Student Email</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Login</button>

        <div class="register">
            <span>New Student?</span> 
            <a href="/student-signup">Create an Account</a>
        </div>

        <?php

    if (isset($_SESSION['login_error'])) {
        echo '<div class="error-message">' . 
             htmlspecialchars($_SESSION['login_error']) . 
             '</div>';
        // Clear the error message after displaying
        unset($_SESSION['login_error']);
    }
    ?>
    </form>
</div>
    </main> 
    <?php include '../src/Views/footer.php'; ?>    

</body>
</html>
