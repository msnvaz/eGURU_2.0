<?php
namespace App\Controllers\student;

class StudentDashboardController {
    public function showStudentDashboardPage() {
        // Ensure user is logged in
        
        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        // Include the dashboard view
        include '../src/Views/student/dashboard.php';
    }
}