<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminDashboardModel;
use App\Models\admin\AdminLoginModel; // Add this import

class AdminDashboardController {
    private $model;

    public function __construct() {
        $this->model = new AdminDashboardModel();
        $this->loginModel = new AdminLoginModel(); // Initialize the login model
    }

    public function showDashboard() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); // Redirect to login page if not logged in
            exit();
        }        
        
        // Fetch all required data for the dashboard
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
        $platformFee = (int)($this->model->getPlatformFee());
        $expectedRevenue = ($totalTutorPoints * $pointValue * $platformFee)/100;
        $totalRevenue = ($this->model->getTotalRevenue())*$pointValue;
        $sessionFeedbackRatings = $this->model->getSessionFeedbackRatings();
        $averageSessionRating = (float)($this->model->getAverageSessionRating());
        
        // Format month numbers to ensure all 12 months are represented in charts
        $studentRegistrationsByMonth = $this->formatMonthlyData($studentRegistrations);
        $tutorRegistrationsByMonth = $this->formatMonthlyData($tutorRegistrations);
        
        // Prepare data for the session status chart
        $sessionData = [];
        foreach ($sessionCounts as $status) {
            $sessionData[$status['session_status']] = $status['total'];
        }
        
        // Include the view and pass the data
        require_once __DIR__ . '/../../Views/admin/AdminDashboard.php';    
    }
    
    /**
     * Helper method to format monthly data to ensure all 12 months are represented
     */
    private function formatMonthlyData($monthlyData) {
        $formattedData = array_fill(1, 12, 0); // Initialize with 0 for all 12 months
        
        foreach ($monthlyData as $data) {
            $month = (int)$data['month'];
            $formattedData[$month] = (int)$data['total'];
        }
        
        return array_values($formattedData); // Convert to indexed array for Chart.js
    }

}