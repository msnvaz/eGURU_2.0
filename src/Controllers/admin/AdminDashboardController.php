<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminDashboardModel;

class AdminDashboardController {
    private $model;
    private $subjectModel;
    private $feeRequestModel;

    public function __construct() {
        $this->model = new AdminDashboardModel();
    }

    public function showDashboard() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); // Redirect to login page if not logged in
            exit();
        }        
        // Include the views and pass the data
$totalStudents = $this->model->getTotalStudents();
$totalTeachers = $this->model->getTotalTeachers();
$activeSessions = $this->model->getActiveSessions();
$revenue = $this->model->getRevenue();

$totalTutors = $this->model->getTotalTutors();
$totalRevenue = $this->model->getTotalRevenue();
$totalSessions = $this->model->getTotalSessions();
$completedSessions = $this->model->getCompletedSessions();
require_once __DIR__ . '/../../Views/admin/AdminDashboard.php';    




    }

    public function logout() {
        session_start();
        // Unset all session variables
        $_SESSION = array();

        // Destroy the session
        session_destroy();

        // Redirect to login page
        header('Location: ./admin-login');
        exit();
    }
}
