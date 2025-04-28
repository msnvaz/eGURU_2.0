<?php

namespace App\Controllers\student;

use App\Models\student\Student_profile;

class StudentLoginController {
    private $model;

    public function __construct() {
        $this->model = new Student_profile();
    }

    public function showStudentLoginPage() {
        
        require_once __DIR__ . '/../../views/student/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $student_email = $_POST['email']; 
            $student_password = $_POST['password']; 
    
            
            $success = $this->model->student_login($student_email, $student_password);
            
            if($success){
                $_SESSION['student_id'] = $success['student_id'];
                $_SESSION['student_email'] = $success['student_email'];
                $_SESSION['student_name'] = $success['student_first_name'] . ' ' . $success['student_last_name'];
    
                header("Location: /student-dashboard");
                exit();
            } else {
                $_SESSION['login_error'] = "Invalid credentials, please try again.";
                header("Location: /student-login");
                exit();
            }
        } else {
            exit();
        }
    }

    public function logout() {
        if (isset($_SESSION['student_id'])) {
            $student_id = $_SESSION['student_id'];
    
           
            $query = $this->model->updateStudentLog($student_id, 'offline');
    
            
            session_unset();
            session_destroy();
    
            header("Location: /student-login");
            exit();
        }
    }
    
}