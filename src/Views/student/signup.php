<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Guru Signup</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="css/student/signup.css">
</head>

<body>
    <div class="container">
        <div class="form-box">
            <div class="form-header">
                <h1>Welcome to e-Guru</h1>
                <p class="subtitle">Start your learning journey today</p>
            </div>
            <form id="signupForm" method="post" action="student_signup">
                <div class="input-group">
                    <div class="input-field">
                        <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-field">
                        <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="input-field">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <span class="error-message"></span>
                </div>
                <div class="input-field password-field">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
                    <div class="password-strength"></div>
                    <span class="error-message"></span>
                </div>
                <div class="input-field password-field">
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password"
                        required>
                    <span class="toggle-password" onclick="togglePassword('confirm-password')">👁️</span>
                    <span class="error-message"></span>
                </div>
                <div class="input-group">
                    <div class="input-field">
                        <input type="date" id="date" name="date" required>
                        <span class="error-message"></span>
                    </div>
                    <div class="input-field">
                        <input type="tel" id="tel" name="tel" placeholder="Contact Number" required>
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="terms">
                    <label>
                        <input type="checkbox" id="terms" required>
                        <span>I agree to the <a href="#">Terms & Privacy Policy</a></span>
                    </label>
                    <span class="error-message"></span>
                </div>
                <button type="submit" class="signup-btn">
                    <span class="btn-text">Sign Up</span>
                    <div class="spinner"></div>
                </button>
                <?php
                if (isset( $_SESSION['signup_error'])) {
                    echo '<div class="alert alert-danger">' .
                        htmlspecialchars( $_SESSION['signup_error']) .
                        '</div>';
                    // Clear the error message after displaying
                    unset( $_SESSION['signup_error']);
                }
                ?>
                <p class="login-link">Already have an account? <a href="/student-login">Login</a></p>


            </form>
        </div>
    </div>

    <script src="js/student/signup.js"></script>

</body>

</html>