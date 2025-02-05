<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Guru Signin</title>
    <link rel="stylesheet" href="\css\tutor\signup.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
</head>
<body>
<?php include '../src/Views/navbar.php'; ?>

    <div class="container">
        <div class="form-box">
            <h1>Welcome to e-Guru</h1>
            <form action="signup.php" method="POST">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="text" name="nic" placeholder="NIC" required>
                <input type="tel" name="contact_number" placeholder="Contact Number" required>
                <div class="terms">
                    <input type="checkbox" required>
                    <label>I agree to the <a href="#">Terms & Privacy Policy</a></label>
                </div>
                <button type="submit">Sign Up</button>
            </form>

        </div>
    </div>

    
</body>
</html>
