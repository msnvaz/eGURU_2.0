<?php
    namespace App\Controllers\admin;
    use App\Models\admin\adminTutorGradingModel;

    class AdminTutorGradingController{
        private $model;

        public function __construct(){
            if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
                header('Location: /admin-login'); // Redirect to login page if not logged in
                exit();
            } 
            $this->model = new adminTutorGradingModel();
        }

        public function showAllGrades(){
            $gradeModel = new adminTutorGradingModel();
            $grades = $gradeModel->getAllGrades();  // Get all students from the mode
            //have to add search
            require_once __DIR__ . '/../../Views/admin/AdminTutorGrades.php';
        }

        public function updateGrade() {
            //check if the grade name exists
            $grade_id = $_POST['grade_id'];
            $grade = $_POST['grade_name'];
            $qualification = $_POST['qualification'];
            $pay_per_hour = $_POST['pay_per_hour'];
            if(!$this->model->updateGrade($grade_id, $grade, $qualification, $pay_per_hour)){
                echo "script>alert('Grade name already exists');
                window.location.href='/admin-tutor-grading';
                </script>";
            }else{
            header('Location: /admin-tutor-grading');
            exit();
            }
        }
        
    }

        
?>