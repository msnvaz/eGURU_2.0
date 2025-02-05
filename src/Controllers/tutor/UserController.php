<?php
include_once 'Model/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        session_start();  // Start the session to manage login state
        $this->userModel = new UserModel();
    }

    public function displayLogin() {
        // Fetch error message from session if it exists
        $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
        unset($_SESSION['error']);  // Clear error message after displaying

        include 'View/login.html';
    }

    // UserController.php

public function processLogin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']); // Trim whitespace from the password

        // Basic input validation
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email and password are required';
            header("Location: index.php?action=login");
            exit();
        }

        // Validate user credentials
        $user = $this->userModel->validateUser($email, $password);

        if ($user) {
            // Regenerate session ID for security after login
            session_regenerate_id(true);

            // Set session variables for the logged-in user
            $_SESSION['loggedin'] = true;
            $_SESSION['tutor_id'] = $user['tutor_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['tutor_level'] = $user['tutor_level'];

            // Redirect to dashboard.php after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = 'Invalid credentials or account not approved';
            header("Location: index.php?action=login");
            exit();
        }
    } else {
        $_SESSION['error'] = 'Invalid request method';
        header("Location: index.php?action=login");
        exit();
    }
}

}
