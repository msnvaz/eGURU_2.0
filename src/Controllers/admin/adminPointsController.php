<?php
namespace App\Controllers\admin;

use App\Models\admin\adminPointsModel;
use App\Controllers\admin\CustomPDFGenerator;

class adminPointsController {
    private $model;

    public function __construct() {
        $this->model = new adminPointsModel();
    }

    public function showAllPoints() {
        // Ensure admin is logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login');
            exit();
        }
    
        $records = [];
        $searchTerm = '';
        $startDate = '';
        $endDate = '';
        $tutorId = '';
        $studentId = '';
        $transactionType = '';  // 'purchase' for student purchases, 'cashout' for tutor cashouts
        $pointsMin = '';
        $pointsMax = '';
    
        // Get transaction type filter value if present (from either POST or GET)
        $transactionType = isset($_POST['transaction_type']) ? $_POST['transaction_type'] : 
                         (isset($_GET['transaction_type']) ? $_GET['transaction_type'] : '');
    
        // Handle search and filter logic
        if (isset($_POST['search'])) {
            // Search by text term
            if (isset($_POST['search_term']) && !empty($_POST['search_term'])) {
                $searchTerm = $_POST['search_term'];
                $records = $this->model->searchPointTransactions($searchTerm, $transactionType);
            } 
            // Filter by various criteria
            else {
                $startDate = $_POST['start_date'] ?? '';
                $endDate = $_POST['end_date'] ?? '';
                $tutorId = $_POST['tutor_id'] ?? '';
                $studentId = $_POST['student_id'] ?? '';
                $pointsMin = $_POST['points_min'] ?? '';
                $pointsMax = $_POST['points_max'] ?? '';
    
                // If any filter is applied
                if (!empty($startDate) || !empty($endDate) || !empty($tutorId) || !empty($studentId) || 
                    !empty($pointsMin) || !empty($pointsMax)) {
                    $records = $this->model->filterPointTransactions(
                        $startDate, $endDate, $tutorId, $studentId, 
                        $transactionType, $pointsMin, $pointsMax
                    );
                }
                // If no specific filters are applied but search was clicked, show all records
                // with the selected transaction type (if any)
                else {
                    $records = $this->model->getAllPointTransactions($transactionType);
                }
            }
        } 
        // If no search button was clicked, show all records
        else {
            $records = $this->model->getAllPointTransactions($transactionType);
            
        }
    
        // Populate tutor and student dropdowns
        $tutors = $this->model->getAllTutors();
        $students = $this->model->getAllStudents();
        $platformFee = $this->model->getPlatformFee(); // Fetch platform fee
    
        // Render the view
        require_once __DIR__ . '/../../Views/admin/AdminPoints.php';
    }

}
?>