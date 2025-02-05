<?php
    namespace App\Controllers\admin;
    use App\Models\admin\adminStudentModel;

    class adminStudentController{
        private $model;

        public function __construct(){
            if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
                header('Location: /admin-login'); // Redirect to login page if not logged in
                exit();
            } 
            $this->model = new adminStudentModel();
        }

        public function showAllStudents(){
            $studentModel = new adminStudentModel();
            $students = $studentModel->getAllStudents();  // Get all students from the mode
            //have to add search
            require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
        }

        public function searchStudents(){
            $studentModel = new adminStudentModel();
            $students = $studentModel->getAllStudents();  // Get all students from the mode
            //have to add search
            require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
        }

        public function showStudentProfile($studentId){
            $studentModel = new adminStudentModel();
            $student = $studentModel->getStudentProfile($studentId);  // Get student profile from the model
            require_once __DIR__ . '/../../Views/admin/AdminStudentProfile.php';
        }
    }
?>