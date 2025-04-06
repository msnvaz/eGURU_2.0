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
        $status = '';  // Added status variable

        // Handle search and filter logic
        if (isset($_POST['search'])) {
            // Get status filter value if present
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            
            // Search by text term
            if (isset($_POST['search_term']) && !empty($_POST['search_term'])) {
                $searchTerm = $_POST['search_term'];
                $sessions = $this->model->searchSessions($searchTerm, $status);  // Pass status parameter
            } 
            // Filter by date range and/or tutor/student
            else {
                $startDate = $_POST['start_date'] ?? '';
                $endDate = $_POST['end_date'] ?? '';
                $tutorId = $_POST['tutor_id'] ?? '';
                $studentId = $_POST['student_id'] ?? '';

                // If any filter is applied
                if (!empty($startDate) || !empty($endDate) || !empty($tutorId) || !empty($studentId) || !empty($status)) {
                    $sessions = $this->model->filterSessions($startDate, $endDate, $tutorId, $studentId, $status);  // Pass status parameter
                }
            }
        } 
        // If no search, show all sessions
        else {
            // Check if status filter is in GET parameters (for pagination)
            $status = isset($_GET['status']) ? $_GET['status'] : '';
            $sessions = $this->model->getAllSessions($status);  // Pass status parameter
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