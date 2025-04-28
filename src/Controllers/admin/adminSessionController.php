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
        $status = '';  

        if (isset($_POST['search'])) {
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            
            if (isset($_POST['search_term']) && !empty($_POST['search_term'])) {
                $searchTerm = $_POST['search_term'];
                $sessions = $this->model->searchSessions($searchTerm, $status);   
            } 
            else {
                $startDate = $_POST['start_date'] ?? '';
                $endDate = $_POST['end_date'] ?? '';
                $tutorId = $_POST['tutor_id'] ?? '';
                $studentId = $_POST['student_id'] ?? '';

                if (!empty($startDate) || !empty($endDate) || !empty($tutorId) || !empty($studentId) || !empty($status)) {
                    $sessions = $this->model->filterSessions($startDate, $endDate, $tutorId, $studentId, $status);   
                }
            }
        } 
        else {
            $status = isset($_GET['status']) ? $_GET['status'] : '';
            $sessions = $this->model->getAllSessions($status);   
        }

        $tutors = $this->model->getAllTutors();
        $students = $this->model->getAllStudents();

        if (isset($_POST['download_pdf'])) {
            $this->downloadSessionsPDF($sessions);
            exit();
        }

        require_once __DIR__ . '/../../Views/admin/AdminSessions.php';
    }

    private function downloadSessionsPDF($sessions) {
        try {
            if (empty($sessions)) {
                throw new \Exception('No sessions found to generate PDF');
            }

            $pdfGenerator = new CustomPDFGenerator();
            $pdfGenerator->generateSessionsPDF($sessions);
        } catch (\Exception $e) {
            error_log('PDF Generation Error: ' . $e->getMessage());
            
            $_SESSION['error_message'] = 'Unable to generate PDF. Please try again or contact support.';
            
            header('Location: /admin/sessions');
            exit();
        }
    }
}
?>