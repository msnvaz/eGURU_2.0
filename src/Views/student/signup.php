<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Guru Signup</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-color: #ec5273;
            --primary-dark: #d94560;
            --error-color: #ff4444;
            --success-color: #00c853;
            --text-light: rgba(255, 255, 255, 0.9);
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('../../images/student-uploads/bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 20px;
            perspective: 1000px;
        }

        .form-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform-style: preserve-3d;
            transition: transform 0.3s ease;
        }

        .form-box:hover {
            transform: translateZ(20px);
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            color: white;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .input-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .input-field {
            position: relative;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        input:focus {
            background: white;
            border-color: var(--primary-color);
        }

        .password-field {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .toggle-password:hover {
            opacity: 1;
        }

        .error-message {
            position: absolute;
            left: 0;
            bottom: -20px;
            font-size: 0.8rem;
            color: var(--error-color);
            transition: all 0.3s ease;
        }

        .password-strength {
            position: absolute;
            bottom: -3px;
            left: 0;
            height: 3px;
            width: 0;
            transition: all 0.3s ease;
        }

        .terms {
            margin: 20px 0;
            color: white;
            text-align: center;
        }

        .terms label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
        }

        .terms input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .terms a {
            color: #ffcccb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .terms a:hover {
            color: white;
        }

        .signup-btn {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 20px 0;
            position: relative;
            overflow: hidden;
        }

        .signup-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .signup-btn:active {
            transform: translateY(0);
        }

        .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .login-link {
            text-align: center;
            color: white;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #ffcccb;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: white;
        }

        input.error {
            border-color: var(--error-color);
            background: rgba(255, 68, 68, 0.1);
        }

        input.valid {
            border-color: var(--success-color);
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            text-align: center;
        }

        @media (max-width: 480px) {
            .input-group {
                grid-template-columns: 1fr;
            }

            .form-box {
                padding: 30px 20px;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
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
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
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

    <script>
        // Validation patterns
        // const patterns = {
        //     firstname: /^[A-Za-z]{2,30}$/,
        //     lastname: /^[A-Za-z]{2,30}$/,
        //     email: /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/,
        //     password: '',
        //     tel: /^\+?[\d\s-]{10,}$/
        // };

        const errorMessages = {
            firstname: 'First name should be 2-30 letters',
            lastname: 'Last name should be 2-30 letters',
            email: 'Please enter a valid email address',
            password: 'Password must be at least 8 characters with 1 letter, 1 number, and 1 special character',
            'confirm-password': 'Passwords do not match',
            date: 'Please select your date of birth',
            tel: 'Please enter a valid phone number',
            terms: 'You must accept the terms and conditions'
        };

        function validateField(field, pattern) {
            if (!pattern) return true;
            return pattern.test(field.value);
        }

        function showError(field, message) {
            const errorElement = field.parentElement.querySelector('.error-message');
            field.classList.add('error');
            field.classList.remove('valid');
            errorElement.textContent = message;
        }

        function showSuccess(field) {
            const errorElement = field.parentElement.querySelector('.error-message');
            field.classList.remove('error');
            field.classList.add('valid');
            errorElement.textContent = '';
        }

        function updatePasswordStrength(password) {
            const strengthBar = document.querySelector('.password-strength');
            const strength = {
                0: 'Too weak',
                1: 'Weak',
                2: 'Medium',
                3: 'Strong'
            };

            let score = 0;
            if (password.length >= 8) score++;
            if (password.match(/[A-Z]/)) score++;
            if (password.match(/[0-9]/)) score++;
            if (password.match(/[^A-Za-z0-9]/)) score++;

            const colors = {
                0: '#ff4444',
                1: '#ffbb33',
                2: '#00c851',
                3: '#007e33'
            };

            strengthBar.style.width = `${(score / 4) * 100}%`;
            strengthBar.style.backgroundColor = colors[score];
        }

        // Form handling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('signupForm');
            const inputs = form.querySelectorAll('input');

            // Add validation listeners to all inputs
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (input.type === 'password' && input.id === 'password') {
                        updatePasswordStrength(input.value);
                    }

                    if (patterns[input.id]) {
                        if (validateField(input, patterns[input.id])) {
                            showSuccess(input);
                        } else {
                            showError(input, errorMessages[input.id]);
                        }
                    }

                    // Special check for confirm password
                    if (input.id === 'confirm-password') {
                        const password = document.getElementById('password').value;
                        if (input.value === password) {
                            showSuccess(input);
                        } else {
                            showError(input, errorMessages['confirm-password']);
                        }
                    }
                });
            });

            // Toggle password visibility
            window.togglePassword = function(fieldId) {
                const field = document.getElementById(fieldId);
                const type = field.type === 'password' ? 'text' : 'password';
                field.type = type;
            };

            // Form submission
            // form.addEventListener('submit', function(e) {
            //     e.preventDefault();
            //     let isValid = true;

            //     // Validate all fields
            //     inputs.forEach(input => {
            //         if (input.type === 'checkbox') {
            //             if (!input.checked) {
            //                 isValid = false;
            //                 showError(input, errorMessages[input.id]);
            //             }
            //         } else if (patterns[input.id]) {
            //             if (!validateField(input, patterns[input.id])) {
            //                 isValid = false;
            //                 showError(input, errorMessages[input.id]);
            //             }
            //         }

            //         if (input.id === 'confirm-password') {
            //             const password = document.getElementById('password').value;
            //             if (input.value !== password) {
            //                 isValid = false;
            //                 showError(input, errorMessages['confirm-password']);
            //             }
            //         }

            //         if (input.id === 'date' && !input.value) {
            //             isValid = false;
            //             showError(input, errorMessages['date']);
            //         }
            //     });

            //     if (isValid) {
            //         const button = form.querySelector('.signup-btn');
            //         const btnText = button.querySelector('.btn-text');
            //         const spinner = button.querySelector('.spinner');

            //         // Show loading state
            //         btnText.style.opacity = '0';
            //         spinner.style.display = 'block';
            //         button.disabled = true;

            //         // Simulate form submission (replace with actual submission)
            //         setTimeout(() => {
            //             form.submit();
            //         }, 1500);
            //     }
            // });
        });
    </script>
</body>

</html>