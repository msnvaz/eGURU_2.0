<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminDashboardModel;
use App\Models\admin\AdminLoginModel; // Add this 
use App\Models\admin\AdminPointsModel; // Add this

class AdminDashboardController {
    private $model;
    private $AdminPointModel;

    public function __construct() {
        $this->model = new AdminDashboardModel();
        $this->loginModel = new AdminLoginModel(); // Initialize the login model
        $this->AdminPointModel = new AdminPointsModel(); // Initialize the point model
    }

    public function showDashboard() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); // Redirect to login page if not logged in
            exit();
        }        
        
        $totalStudents = $this->model->getTotalStudents();
        $totalTutors = $this->model->getTotalTutors();
        $totalSessions = $this->model->getTotalSessions();
        $completedSessions = $this->model->getCompletedSessions();
        $sessionCounts = $this->model->getSessionCountsByStatus();
        $studentRegistrations = $this->model->getStudentRegistrationsByMonth();
        $tutorRegistrations = $this->model->getTutorRegistrationsByMonth();
        $sessionsPerSubject = $this->model->getSessionsPerSubject();
        $totalStudentPoints = (int)($this->model->getTotalStudentPoints());
        $totalTutorPoints = (int)($this->model->getTotalTutorPoints());
        $pointValue = (int)($this->model->getPointValue());

        $platformFee = (float)($this->model->getPlatformFee());
        $payables = (($totalTutorPoints) * $pointValue * (100-$platformFee))/100;
        $recievables = (($totalTutorPoints) * $pointValue * $platformFee)/100;

        $sessionFeedbackRatings = $this->model->getSessionFeedbackRatings();
        $averageSessionRating = (float)($this->model->getAverageSessionRating());

        $totalCashouts = (float)($this->model->getTotalCashouts());
        $totalPurchases = (float)($this->model->getTotalPurchases());
        $cashInHand = $totalPurchases-($totalCashouts*((100-$platformFee)/100));
        
        $studentRegistrationsByMonth = $this->formatMonthlyData($studentRegistrations);
        $tutorRegistrationsByMonth = $this->formatMonthlyData($tutorRegistrations);

        $monthlyCashouts = $this->model->getMonthlyCashouts();
        $monthlyCashoutsData = $this->formatMonthlyData($monthlyCashouts);
        
        
        $sessionData = [];
        foreach ($sessionCounts as $status) {
            $sessionData[$status['session_status']] = $status['total'];
        }
        
        
        require_once __DIR__ . '/../../Views/admin/AdminDashboard.php';    
    }
    
    
    private function formatMonthlyData($monthlyData) {
        $formattedData = array_fill(1, 12, 0); // Initialize with 0 for all 12 months
        
        foreach ($monthlyData as $data) {
            $month = (int)$data['month'];
            $formattedData[$month] = (int)$data['total'];
        }
        
        return array_values($formattedData); // Convert to indexed array for Chart.js
    }

}