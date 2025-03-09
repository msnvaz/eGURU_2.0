<?php
namespace App\Controllers\Student;

use App\Models\student\StudentDashboardModel;
use DateTime;

class StudentDashboardController {
    private $model;

    public function __construct() {
       
        $this->model = new StudentDashboardModel();
    }

    public function showStudentDashboardPage() {
        // Ensure user is logged in
        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        // Include the dashboard view
        include __DIR__ . '/../../Views/student/dashboard.php';
    }

    public function getTutorReplies() {
        if (!isset($_SESSION['student_id'])) {
            return [];
        }

        $studentId = $_SESSION['student_id'];
        return $this->model->getTutorReplies($studentId);
    }

    public function formatDateTime($datetime) {
        $date = new DateTime($datetime);
        return $date->format('j M Y - g:i A');
    }
}
?>