<?php

namespace App\Controllers\student;

use App\Models\StudentDetailsModel;
use App\Models\student\Student_profile;

class StudentLoginController {
    private $model;

    public function __construct() {
        $this->model = new Student_profile();
    }

    /**
     * Displays the student login page with a list of students.
     */
    public function showStudentLoginPage() {
        // Fetch all studentss from the database
        //$ads = $this->model->getALLStudents();

        // Pass data to the view
        
        require_once __DIR__ . '/../../views/student/login.php';
    }

    public function login(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
             $email = $_POST['email'];
             $password = $_POST['password'];
             $success = $this->model->student_login($email,$password);
             if($success){
                 $_SESSION['student_id'] = $success['id'];
                 $_SESSION['student_email'] = $success['email'];
                 $_SESSION['student_name'] =$success['firstname'] . ' ' . $success['lastname'];

                 header("Location: /student-dashboard");
             }
             else{
                 header("Location: /student-login");
                 exit();
             }
     }
     else{
         exit();
     }
 }
    
}