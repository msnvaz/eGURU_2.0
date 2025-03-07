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
            // Use the correct names as per the HTML form field names
            $student_email = $_POST['email']; // 'email' from the view form
            $student_password = $_POST['password']; // 'password' from the view form
    
            // Attempt login
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
    
}