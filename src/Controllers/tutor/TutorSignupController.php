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
        require_once __DIR__ . '/../../Views/tutor/signup.php';
    }

    /**
     * Handles tutor signup.
     */
    public function handleSignup() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $birth_date = $_POST['birth_date'];
            $password = $_POST['password'];
            $nic = $_POST['nic'];
            $contactNumber = $_POST['contact_number'];
    
            $registrationDate = date('Y-m-d H:i:s'); // current datetime
    
            $highest_qualification = null;
    
            if (isset($_FILES['highest-qualification']) && $_FILES['highest-qualification']['error'] == 0) {
                $uploadDir = './uploads/tutor_qualification_proof/';
                $fileName = basename($_FILES['highest-qualification']['name']);
                $uploadPath = $uploadDir . $fileName;
    
                if (move_uploaded_file($_FILES['highest-qualification']['tmp_name'], $uploadPath)) {
                    $highest_qualification = $fileName;
                } else {
                    
                }
            }
    
            try {
                // Include registration date in the function call
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
    
                header("Location: /tutor-login");
                exit;
            } catch (\Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
    
}
