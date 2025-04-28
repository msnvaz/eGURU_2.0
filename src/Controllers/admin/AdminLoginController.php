<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminLoginModel;
use App\Router;

class AdminLoginController {
    private $model;

    public function __construct() {
        $this->model = new AdminLoginModel();
    }

    public function showLoginPage() {
        require_once __DIR__ . '/../../Views/admin/login.php';
    }

    public function checkAdminLogin() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $username = $_POST['username'];
        $password = $_POST['password'];
    
        if (isset($_POST['confirm_logout']) && isset($_SESSION['pending_admin_id'])) {
            if ($_POST['confirm_logout'] === 'yes') {
                $this->model->forceLogout($_SESSION['pending_admin_id']);
                $this->completeLogin($username, $_SESSION['pending_admin_id']);
                return;
            } else {
                unset($_SESSION['pending_admin_id']);
                $_SESSION['error_message'] = 'Login canceled. Previous session remains active.';
                Router::redirect('/admin-login');
                return;
            }
        }
    
        $loginResult = $this->model->login($username, $password);
    
        switch ($loginResult['status']) {
            case 'success':
                $this->completeLogin($username, $loginResult['admin_id']);
                break;
                
            case 'already_logged_in_locally':
                Router::redirect('/admin-dashboard'); 
                break;
                
            case 'already_logged_in_elsewhere':
                $_SESSION['pending_admin_id'] = $loginResult['admin_id'];
                $_SESSION['pending_username'] = $username;
                
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

    private function completeLogin($username, $adminId) {
        $this->model->updateLoginStatus($adminId, true);
        
        $_SESSION['admin'] = $username;
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $adminId;
        $_SESSION['admin_username'] = $username;  
        
        Router::redirect('/admin-dashboard');
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        error_log("Logout initiated. Admin ID in session: " . (isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 'not set'));
        
        if (isset($_SESSION['admin_id'])) {
            $adminId = $_SESSION['admin_id'];
            $result = $this->model->updateLoginStatus($adminId, false);
            
            error_log("Admin logout status update for ID $adminId: " . ($result ? 'successful' : 'failed'));
            
            if (!$result) {
                error_log("Failed to update admin login status in database");
            }
        }
        
        $_SESSION = array();
        session_destroy();
        
        header('Location: /admin-login');
        exit();
    }
}