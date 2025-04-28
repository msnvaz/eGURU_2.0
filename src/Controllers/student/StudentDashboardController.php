<?php
namespace App\Controllers\Student;

use App\Models\student\StudentDashboardModel;
use App\Models\student\EventModel; 
use App\Config\Database; 
use DateTime;

class StudentDashboardController {
    private $model;
    private $eventModel; 
    private $studentId; 

    public function __construct() {
        $this->model = new StudentDashboardModel();

        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        
        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        $this->studentId = $_SESSION['student_id'];

        
        $database = new Database();
        $db = $database->connect();
        $this->eventModel = new EventModel($db);
    }

    public function showStudentDashboardPage() {
        
        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
    
        $studentId = $_SESSION['student_id'];
    
        
        $studentPoints = $this->model->getStudentPoints($studentId);
        $studentProfilePhoto = $this->model->getStudentProfilePhoto($studentId);
    
        
        $_SESSION['student_points'] = $studentPoints;
        $_SESSION['student_profile_photo'] = $studentProfilePhoto;
    
        
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
        return $this->eventModel->getLimitedUpcomingEvents($this->studentId, 2); 
    }

    public function getPreviousEvents() {
        return $this->eventModel->getLimitedPreviousEvents($this->studentId, 2); 
    }

    public function formatDateTime($datetime) {
        $date = new DateTime($datetime);
        return $date->format('j M Y - g:i A');
    }
}