<?php 

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;
use DateTime;

class TutorSignupController {
    private $model;

    public function __construct() {
        $this->model = new TutorDetailsModel();
    }

   
    public function showTutorSignupPage() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        require_once __DIR__ . '/../../Views/tutor/signup.php';
    }

    
    public function handleSignup()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $birth_date = $_POST['birth_date'];
        $password = $_POST['password'];
        $nic = trim($_POST['nic']);
        $contactNumber = trim($_POST['contact_number']);

        $registrationDate = date('Y-m-d H:i:s');
        $highest_qualification = null;

        
        $registrationStatus = $this->model->getAdminSettingValue('tutor_registration');

        if ($registrationStatus !== '1') { 
            $_SESSION['error'] = "Tutor Signup is Closed Temporarily. Try again later.";
            header("Location: /tutor-signup");
            exit;
        }

        
        if (!preg_match("/^[a-zA-Z]+$/", $firstName) || !preg_match("/^[a-zA-Z]+$/", $lastName)) {
            $_SESSION['error'] = "First name and last name can only contain letters (A-Z or a-z).";
            header("Location: /tutor-signup");
            exit;
        }

        
        $birthDateTime = new DateTime($birth_date);
        $today = new DateTime();
        $age = $today->diff($birthDateTime)->y;

        if ($age < 18) {
            $_SESSION['error'] = "You must be at least 18 years old to sign up.";
            header("Location: /tutor-signup");
            exit;
        }

        
        if ($this->model->checkEmailExists($email)) {
            $_SESSION['error'] = "An account with this email already exists. Please try logging in or use a different email.";
            header("Location: /tutor-signup");
            exit;
        }

        
        if (isset($_FILES['highest-qualification']) && $_FILES['highest-qualification']['error'] == 0) {
            $uploadDir = './uploads/tutor_qualification_proof/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true); 
            }
            $fileName = basename($_FILES['highest-qualification']['name']);
            $uploadPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['highest-qualification']['tmp_name'], $uploadPath)) {
                $highest_qualification = $fileName;
            }
        }

        try {
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $this->model->createTutor(
                $firstName,
                $lastName,
                $email,
                $birth_date,
                $hashedPassword,
                $nic,
                $contactNumber,
                $highest_qualification,
                $registrationDate
            );

            header("Location: /tutor-signup?success=true");
            exit;
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

}
