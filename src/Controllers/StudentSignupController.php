<?php

namespace App\Controllers;

use App\Models\Student_profile;

class StudentSignupController {
    private $model;

    public function __construct() {
        $this->model = new Student_profile();
    }

    /**
     * Displays the student signup page.
     */
    public function showStudentSignupPage() {
        require_once __DIR__ . '/../Views/student/signup.php';
    }

    /**
     * Handles student signup.
     */
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