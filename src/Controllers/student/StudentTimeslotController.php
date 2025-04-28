<?php

namespace App\Controllers\student;

use App\Models\student\TimeslotModel;

class StudentTimeslotController {
    private $model;

    public function __construct() {
        $this->model = new TimeslotModel();
    }

    
    public function showStudentTimeSlotPage() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        if (!isset($_SESSION['student_id'])) {
            
            header("Location: /student-login");
            exit;
        }

        $studentId = $_SESSION['student_id'];

        
        $allTimeSlots = $this->model->getAllTimeSlots();
        $selectedSlots = $this->model->getStudentTimeSlots($studentId);

        
        require_once __DIR__ . '/../../Views/student/timeslot.php';
    }

    
    public function saveStudentTimeSlots() {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        
        if (!isset($_SESSION['student_id'])) {
            
            header("Location: /student-login");
            exit;
        }

        $studentId = $_SESSION['student_id'];
        $slotSelections = [];

        
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        
        foreach ($days as $day) {
            if (!empty($_POST[$day])) {
                $slotSelections[$day] = $_POST[$day]; 
            }
        }

        
        $this->model->saveStudentTimeSlots($studentId, $slotSelections);

        
        header("Location: /student-timeslot?success=1");
        exit;
    }
}