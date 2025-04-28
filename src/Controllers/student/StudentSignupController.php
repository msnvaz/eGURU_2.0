<?php

namespace App\Controllers\student;

use App\Models\student\Student_profile;

class StudentSignupController {
    private $model;

    public function __construct() {
        $this->model = new Student_profile();
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function showStudentSignupPage() {
        include '../src/Views/student/signup.php';
    }

    public function student_signup() {             
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {           
            
            $student_first_name = $_POST['firstname'];                 
            $student_last_name = $_POST['lastname'];                 
            $student_email = $_POST['email'];                 
            $student_password = $_POST['password'];                 
            $student_DOB = $_POST['date'];  
            $student_phonenumber = $_POST['tel'];  
    
            if (!preg_match('/^(?=.*[a-z])(?=.*[@$!%*?&])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $student_password)) {
                $_SESSION['signup_error'] = "Password must be strong.";
                header("Location: /student-signup");
                exit();
            }

            if (strlen($student_phonenumber) !== 10 || !ctype_digit($student_phonenumber)) {
                $_SESSION['signup_error'] = "Phone number must be exactly 10 digits.";
                header("Location: /student-signup");
                exit();
            }

            
            $dob = new \DateTime($student_DOB);
            $currentDate = new \DateTime();
            $age = $currentDate->diff($dob)->y;
    
            if ($age < 10) {
                $_SESSION['signup_error'] = "You must be at least 10 years old to register.";
                header("Location: /student-signup");
                exit();
            }
    
            
            if ($this->model->check_email($student_email)) {
                $_SESSION['signup_error'] = "Email already exists";
                header("Location: /student-signup");
                exit();
            } else {
                
                $signup_result = $this->model->student_signup($student_first_name, $student_last_name, $student_email, $student_password, $student_DOB, $student_phonenumber);
    
                if ($signup_result) {
                    $_SESSION['student_id'] = $signup_result['student_id'];
                    $_SESSION['student_name'] = $signup_result['student_first_name'] . ' ' . $signup_result['student_last_name'];
                    $_SESSION['student_email'] = $signup_result['student_email'];
                    $_SESSION['student_points'] = $signup_result['student_points'];
    
                  
                    $_SESSION['welcome_message'] = "Welcome " . $signup_result['student_first_name'] . " " . $signup_result['student_last_name'] . "! You've earned " . $signup_result['student_points'] . " student_points.";
    
                    header("Location: /student-login");
                    exit();
                } else {
                    $_SESSION['signup_error'] = "Signup failed. Please try again.";
                    header("Location: /student-signup");
                    exit();
                }
            }
        }
    }
}  