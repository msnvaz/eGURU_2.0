<?php

namespace App\Controllers\student;

use App\Models\student\StudentReportModel;

class StudentReportController {
    private $reportModel;

    public function __construct() {
        $this->reportModel = new StudentReportModel();
    }

    
    public function showReport() {
        
        $studentId = $_SESSION['student_id'] ?? null;
        
        if (!$studentId) {
            
            header('Location: /login');
            exit;
        }
        
        
        $tutors = $this->reportModel->getTutorsWithCompletedSessions($studentId);
        
        
        $previousReports = $this->reportModel->getPreviousReports($studentId);
        
        
        include '../src/Views/student/report.php';
    }
    
    
    public function saveReport() {
        
        $studentId = $_SESSION['student_id'] ?? null;
        
        if (!$studentId) {
            
            header('Location: /login');
            exit;
        }
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tutorId = $_POST['tutor_id'] ?? '';
            $issueType = $_POST['issue_type'] ?? '';
            $description = $_POST['description'] ?? '';
            
            
            if (empty($tutorId) || empty($issueType) || empty($description)) {
                $_SESSION['error_message'] = 'All fields are required.';
                header('Location: /student-report');
                exit;
            }
            
            
            if (!$this->reportModel->hasCompletedSession($studentId, $tutorId)) {
                $_SESSION['error_message'] = 'You can only report tutors with whom you have completed sessions.';
                header('Location: /student-report');
                exit;
            }
            
            
            $result = $this->reportModel->saveReport($studentId, $tutorId, $issueType, $description);
            
            if ($result) {
                $_SESSION['success_message'] = 'Your report has been submitted successfully.';
            } else {
                $_SESSION['error_message'] = 'There was an error submitting your report. Please try again.';
            }
            
            header('Location: /student-report');
            exit;
        }
    }
    
    
    public function getTutorDetails() {
       
        $studentId = $_SESSION['student_id'] ?? null;
        
        if (!$studentId) {
            echo json_encode(['error' => 'Not logged in']);
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tutorId = $_POST['tutor_id'] ?? '';
            
            if (empty($tutorId)) {
                echo json_encode(['error' => 'Tutor ID is required']);
                exit;
            }
            
            
            $tutorDetails = $this->reportModel->getTutorDetails($tutorId);
            
            if ($tutorDetails) {
                echo json_encode($tutorDetails);
            } else {
                echo json_encode(['error' => 'Tutor not found']);
            }
            exit;
        }
    }
}