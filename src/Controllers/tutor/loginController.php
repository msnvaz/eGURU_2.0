<?php
session_start();
include_once '../models/UserModel.php'; // Include the model for database interaction

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve user inputs from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the model's method to validate the user credentials
    if (UserModel::validateUser($email, $password)) {
        // If valid, set session variables and redirect to the dashboard
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        header("Location: ../../Views/tutor/dashboard.php"); // Redirect to the dashboard
        exit;
    } else {
        // If invalid, set an error message and show the login form again
        $errorMessage = "Invalid email or password. Please try again.";
        include '../Views/tutor/login.html'; // Include the login form again with error
    }
} else {
    // If the form has not been submitted, show the login form
    include '../Views/tutor/login.html'; // Include the login form
}
?>
