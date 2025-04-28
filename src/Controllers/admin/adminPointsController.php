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
        $transactionType = '';  
        $pointsMin = '';
        $pointsMax = '';
    
        $transactionType = isset($_POST['transaction_type']) ? $_POST['transaction_type'] : 
                         (isset($_GET['transaction_type']) ? $_GET['transaction_type'] : '');
    
        if (isset($_POST['search'])) {
            if (isset($_POST['search_term']) && !empty($_POST['search_term'])) {
                $searchTerm = $_POST['search_term'];
                $records = $this->model->searchPointTransactions($searchTerm, $transactionType);
            } 
            else {
                $startDate = $_POST['start_date'] ?? '';
                $endDate = $_POST['end_date'] ?? '';
                $tutorId = $_POST['tutor_id'] ?? '';
                $studentId = $_POST['student_id'] ?? '';
                $pointsMin = $_POST['points_min'] ?? '';
                $pointsMax = $_POST['points_max'] ?? '';
    
                if (!empty($startDate) || !empty($endDate) || !empty($tutorId) || !empty($studentId) || 
                    !empty($pointsMin) || !empty($pointsMax)) {
                    $records = $this->model->filterPointTransactions(
                        $startDate, $endDate, $tutorId, $studentId, 
                        $transactionType, $pointsMin, $pointsMax
                    );
                }
                else {
                    $records = $this->model->getAllPointTransactions($transactionType);
                }
            }
        } 
        else {
            $records = $this->model->getAllPointTransactions($transactionType);
            
        }
    
        $tutors = $this->model->getAllTutors();
        $students = $this->model->getAllStudents();
        $platformFee = $this->model->getPlatformFee();  
    
        require_once __DIR__ . '/../../Views/admin/AdminPoints.php';
    }

}
?>