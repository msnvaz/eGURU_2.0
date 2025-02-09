<?php

namespace App\Controllers\student;

use App\Models\student\Student_profile;

class StudentSignupController {
    private $model;

    public function __construct() {
        $this->model = new Student_profile();
        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function showStudentSignupPage() {
        include '../src/Views/student/signup.php';
    }

    public function student_signup() {             
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {           
            // Retrieve signup details
            $firstname = $_POST['firstname'];                 
            $lastname = $_POST['lastname'];                 
            $email = $_POST['email'];                 
            $password = $_POST['password'];                 
            $date = $_POST['date'];                 
            $tel = $_POST['tel'];          

            // Check if email already exists
            if ($this->model->check_email($email)) {
                $_SESSION['signup_error'] = "Email already exists";
                header("Location: /student-signup");
                exit();
            } else {
                // Register the student
                $signup_result = $this->model->student_signup($firstname, $lastname, $email, $password, $date, $tel);

                if ($signup_result) {
                    $_SESSION['student_id'] = $signup_result['id'];
                    $_SESSION['student_name'] = $signup_result['firstname'] . ' ' . $signup_result['lastname'];
                    $_SESSION['student_email'] = $signup_result['email'];
                    $_SESSION['student_points'] = $signup_result['points'];

                    // Set welcome message
                    $_SESSION['welcome_message'] = "Welcome " . $signup_result['firstname'] . " " . $signup_result['lastname'] . "! You've earned " . $signup_result['points'] . " points.";

                    header("Location: /student-dashboard");
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