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
    
        // Process logout confirmation if needed
        if (isset($_POST['confirm_logout']) && isset($_SESSION['pending_admin_id'])) {
            if ($_POST['confirm_logout'] === 'yes') {
                // Force logout previous session
                $this->model->forceLogout($_SESSION['pending_admin_id']);
                // Continue with new login
                $this->completeLogin($username, $_SESSION['pending_admin_id']);
                return;
            } else {
                // User declined to logout previous session
                unset($_SESSION['pending_admin_id']);
                $_SESSION['error_message'] = 'Login canceled. Previous session remains active.';
                Router::redirect('/admin-login');
                return;
            }
        }
    
        // Attempt to log in
        $loginResult = $this->model->login($username, $password);
    
        // Check login result status
        switch ($loginResult['status']) {
            case 'success':
                $this->completeLogin($username, $loginResult['admin_id']);
                break;
                
            case 'already_logged_in_locally':
                Router::redirect('/admin-dashboard'); // Already logged in this browser
                break;
                
            case 'already_logged_in_elsewhere':
                // Store the admin ID for confirmation
                $_SESSION['pending_admin_id'] = $loginResult['admin_id'];
                $_SESSION['pending_username'] = $username;
                
                // Show confirmation page
                require_once __DIR__ . '/../../Views/admin/confirm_logout.php';
                break;
                
            case 'invalid_credentials':
                error_log("Login failed for username: $username");
                $_SESSION['error_message'] = 'Invalid username or password';
                Router::redirect('/admin-login');
                break;
                
            case 'database_error':
                $_SESSION['error_message'] = 'System error. Please try again later.';
                Router::redirect('/admin-login');
                break;
        }
    }

    // Complete the login process
    private function completeLogin($username, $adminId) {
        // Update database login status
        $this->model->updateLoginStatus($adminId, true);
        
        // Set session variables
        $_SESSION['admin'] = $username;
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $adminId;
        
        // Redirect to dashboard
        Router::redirect('/admin-dashboard');
    }

    // Handle logout
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Update database if we have admin ID
        if (isset($_SESSION['admin_id'])) {
            $this->model->updateLoginStatus($_SESSION['admin_id'], false);
        }
        
        // Clear session
        $_SESSION = array();
        session_destroy();
        
        // Redirect to login page
        Router::redirect('/admin-login');
    }
}