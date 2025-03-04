<?php
namespace App\Controllers\admin;

use App\Models\admin\adminSessionModel;
use App\Controllers\admin\CustomPDFGenerator;

class adminSessionController {
    private $model;

    public function __construct() {
        $this->model = new adminSessionModel();
    }

    public function showAllSessions() {
        // Ensure admin is logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login');
            exit();
        }

        $sessions = [];
        $searchTerm = '';
        $startDate = '';
        $endDate = '';
        $tutorId = '';
        $studentId = '';

        // Handle search and filter logic
        if (isset($_POST['search'])) {
            // Search by text term
            if (isset($_POST['search_term']) && !empty($_POST['search_term'])) {
                $searchTerm = $_POST['search_term'];
                $sessions = $this->model->searchSessions($searchTerm);
            } 
            // Filter by date range and/or tutor/student
            else {
                $startDate = $_POST['start_date'] ?? '';
                $endDate = $_POST['end_date'] ?? '';
                $tutorId = $_POST['tutor_id'] ?? '';
                $studentId = $_POST['student_id'] ?? '';

                // If any filter is applied
                if (!empty($startDate) || !empty($endDate) || !empty($tutorId) || !empty($studentId)) {
                    $sessions = $this->model->filterSessions($startDate, $endDate, $tutorId, $studentId);
                }
            }
        } 
        // If no search, show all sessions
        else {
            $sessions = $this->model->getAllSessions();
        }

        // Populate tutor and student dropdowns
        $tutors = $this->model->getAllTutors();
        $students = $this->model->getAllStudents();

        // Check if download PDF is requested
        if (isset($_POST['download_pdf'])) {
            $this->downloadSessionsPDF($sessions);
            exit();
        }

        // Render the view
        require_once __DIR__ . '/../../Views/admin/AdminSessions.php';
    }

    // PDF download method with improved error handling
    private function downloadSessionsPDF($sessions) {
        try {
            // Validate sessions data
            if (empty($sessions)) {
                throw new \Exception('No sessions found to generate PDF');
            }

            $pdfGenerator = new CustomPDFGenerator();
            $pdfGenerator->generateSessionsPDF($sessions);
        } catch (\Exception $e) {
            // Log the full error
            error_log('PDF Generation Error: ' . $e->getMessage());
            
            // Set a user-friendly error message
            $_SESSION['error_message'] = 'Unable to generate PDF. Please try again or contact support.';
            
            // Redirect back to sessions page
            header('Location: /admin/sessions');
            exit();
        }
    }
}
?>