<?php

namespace App\Controllers\manager;

use App\Models\manager\ManagerDashboardModel;

class ManagerDashboardController {
    private $model;

    public function __construct() {
        $this->model = new ManagerDashboardModel();
    }

    public function showDashboard() {
        // Check if admin is logged in
        if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
            header('Location: /manager-login'); // Redirect to login page if not logged in
            exit();
        }        
        // Include the views and pass the data
        require_once __DIR__ . '/../../Views/manager/ManagerDashboard.php';    
    }

    public function logout() {
        session_start();
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to login page
        header('Location: ./manager-login');
        exit();
    }
}