<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminLoginModel;
use App\Router;

class AdminLoginController {
    private $model;

    public function __construct() {
        $this->model = new AdminLoginModel();
    }

    // Show the login page (GET request)
    public function showLoginPage() {
        require_once __DIR__ . '/../../Views/admin/login.php';
    }

    // Check admin login credentials (POST request)
    public function checkAdminLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Get username and password from POST request
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        // Attempt to log in
        $admin = $this->model->login($username, $password);
    
        // Check if login was successful
        if ($admin) {
            $_SESSION['admin'] = $username; // Set session variable
            $_SESSION['admin_logged_in'] = true;
            Router::redirect('/admin-dashboard'); // Redirect to the dashboard
        } else {
            // Log the failed attempt for debugging
            error_log("Login failed for username: $username");
            $_SESSION['error_message'] = 'Login failed';
            Router::redirect('/admin-login'); // Redirect back to the login page
        }
    }

}