<?php
namespace App\Controllers\tutor;


use App\Models\tutor\TutorDetailsModel;

class TutorLoginController {
    public function showLogin() {
        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);
        require_once __DIR__ .'/../../Views/tutor/login.php';
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Create an instance of TutorDetailsModel
            $tutorModel = new TutorDetailsModel();
            $tutorData = $tutorModel->validateTutor($email, $password);
    
            if ($tutorData) {
                session_destroy();
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['tutor_id'] = $tutorData['tutor_id']; // Store tutor ID in session
                $_SESSION['email'] = $email;
                header("Location: /tutor-dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Invalid email or password. Please try again.";
                header("Location: /tutor-login");
                exit;
            }
        }
    }
    
    
}
