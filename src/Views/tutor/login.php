<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Guru Login</title>
    <link rel="stylesheet" href="/css/tutor/login.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <style>
        .error-message {
            color: red;
            background-color:rgba(255, 255, 255, 0.46);
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include '../src/Views/navbar.php'; ?>
    <main>
        <div class="login-container">
            <h1>Welcome to e-Guru</h1>

            <?php if (!empty($error)) : ?>
                <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form action="/tutor-login-action" method="POST">
                <label for="email">Tutor Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login">Login</button>
                
                <div class="register">
                    <span>New Tutor?</span> <a href="/tutor-signup">Create an Account</a>
                </div>
            </form>
        </div>
    </main>
    <?php include '../src/Views/footer.php'; ?>
</body>
</html>
