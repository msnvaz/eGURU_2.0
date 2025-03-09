<?php

namespace App\Controllers\student;

use App\Models\student\StudentReportModel;

class StudentReportController {
    private $reportModel;

    public function __construct() {
        $this->reportModel = new StudentReportModel();
    }

    /**
     * Show the report form and previous reports
     */
    public function showReport() {
        // Get student ID from session
        $studentId = $_SESSION['student_id'] ?? null;
        
        if (!$studentId) {
            // Redirect to login if not logged in
            header('Location: /login');
            exit;
        }
        
        // Get tutors with completed sessions for this student
        $tutors = $this->reportModel->getTutorsWithCompletedSessions($studentId);
        
        // Get previous reports made by this student
        $previousReports = $this->reportModel->getPreviousReports($studentId);
        
        // Include the view
        include '../src/Views/student/report.php';
    }
    
    /**
     * Save a new tutor report
     */
    public function saveReport() {
        // Get student ID from session
        $studentId = $_SESSION['student_id'] ?? null;
        
        if (!$studentId) {
            // Redirect to login if not logged in
            header('Location: /login');
            exit;
        }
        
        // Validate form data
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tutorId = $_POST['tutor_id'] ?? '';
            $issueType = $_POST['issue_type'] ?? '';
            $description = $_POST['description'] ?? '';
            
            // Validate required fields
            if (empty($tutorId) || empty($issueType) || empty($description)) {
                $_SESSION['error_message'] = 'All fields are required.';
                header('Location: /student-report');
                exit;
            }
            
            // Verify the tutor has completed sessions with this student
            if (!$this->reportModel->hasCompletedSession($studentId, $tutorId)) {
                $_SESSION['error_message'] = 'You can only report tutors with whom you have completed sessions.';
                header('Location: /student-report');
                exit;
            }
            
            // Save the report
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
    
    /**
     * Get tutor details for the modal
     */
    public function getTutorDetails() {
        // Get student ID from session
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
            
            // Get tutor details
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