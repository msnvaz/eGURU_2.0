<?php
namespace App\Controllers\Student;

use App\Models\student\StudentDashboardModel;
use App\Models\student\EventModel; // Added for EventModel
use App\Config\Database; // Added for database connection
use DateTime;

class StudentDashboardController {
    private $model;
    private $eventModel; // Added for EventModel
    private $studentId; // Added for student ID

    public function __construct() {
        $this->model = new StudentDashboardModel();

        // Start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if student is logged in
        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        $this->studentId = $_SESSION['student_id'];

        // Initialize EventModel with database connection
        $database = new Database();
        $db = $database->connect();
        $this->eventModel = new EventModel($db);
    }

    public function showStudentDashboardPage() {
        // Ensure user is logged in
        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
    
        $studentId = $_SESSION['student_id'];
    
        // Fetch total purchased points
        $totalPurchasedPoints = $this->model->getTotalPurchasedPoints($studentId);
    
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

    public function getUpcomingEvents() {
        return $this->eventModel->getLimitedUpcomingEvents($this->studentId, 2); // Fetch 2 upcoming events
    }

    public function getPreviousEvents() {
        return $this->eventModel->getLimitedPreviousEvents($this->studentId, 2); // Fetch 2 previous events
    }

    public function formatDateTime($datetime) {
        $date = new DateTime($datetime);
        return $date->format('j M Y - g:i A');
    }
}