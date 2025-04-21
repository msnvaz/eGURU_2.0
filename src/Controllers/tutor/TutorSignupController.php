<?php 

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;

class TutorSignupController {
    private $model;

    public function __construct() {
        $this->model = new TutorDetailsModel();
    }

    /**
     * Displays the tutor signup page.
     */
    public function showTutorSignupPage() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);

        require_once __DIR__ . '/../../Views/tutor/signup.php';
    }

    /**
     * Handles tutor signup.
     */
    public function handleSignup() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $birth_date = $_POST['birth_date'];
            $password = $_POST['password'];
            $nic = $_POST['nic'];
            $contactNumber = $_POST['contact_number'];
    
            $registrationDate = date('Y-m-d H:i:s');
            $highest_qualification = null;

            // Check if email already exists
            if ($this->model->checkEmailExists($email)) {
                $_SESSION['error'] = "An account with this email already exists. Please try logging in or use a different email.";
                header("Location: /tutor-signup");
                exit;
            }

            // Handle file upload
            if (isset($_FILES['highest-qualification']) && $_FILES['highest-qualification']['error'] == 0) {
                $uploadDir = './uploads/tutor_qualification_proof/';
                $fileName = basename($_FILES['highest-qualification']['name']);
                $uploadPath = $uploadDir . $fileName;
    
                if (move_uploaded_file($_FILES['highest-qualification']['tmp_name'], $uploadPath)) {
                    $highest_qualification = $fileName;
                }
            }

            try {
                $this->model->createTutor(
                    $firstName,
                    $lastName,
                    $email,
                    $birth_date,
                    $password,
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
