<?php

namespace App\Controllers\manager;

use App\Models\manager\ManagerLoginModel;
use App\Router;

class ManagerLoginController {
    private $model;

    public function __construct() {
        $this->model = new ManagerLoginModel();
    }

    // Show the login page (GET request)
    public function showLoginPage() {
        require_once __DIR__ . '/../../Views/manager/login.php';
    }

    // Check admin login credentials (POST request)
    public function checkManagerLogin() {
        session_start(); // Start the session at the beginning
    
        // Get username and password from POST request
        $username = $_POST['username'];
        $password = $_POST['password'];
        
    
        // Attempt to log in
        $manager = $this->model->login($username, $password);
        echo $manager;
        // Check if login was successful
        if ($manager) {

            $_SESSION['manager'] = $username; // Set session variable
            Router::redirect('/manager-dashboard'); // Redirect to the dashboard
        } else {
            // Log the failed attempt for debugging
            error_log("Login failed for username: $username");
            //pass the message to error_message
            $_SESSION['error_message'] = 'Login failed';
            echo $username;
            Router::redirect('/manager-login'); // Redirect back to the login page
        }
    }

}