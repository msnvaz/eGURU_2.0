<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorProfileModel;
use App\Models\tutor\FeedbackModel;

class TutorPublicProfileController {
    private $model;
    private $feedbackmodel;

    public function __construct() {
        $this->model = new TutorProfileModel();
        $this->feedbackmodel = new FeedbackModel();

    }

    public function showPublicProfilePage() {
        
        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;

        
        $profileData = [];
        $contactInfo = [];
        $tutorRating = null;
        }
        if (isset($_SESSION['tutor_id'])) {
        $tutorRating = $this->feedbackmodel->getRatingByTutor($_SESSION['tutor_id']);
        $profileData = $this->model->getProfileByTutorId($_SESSION['tutor_id']);
        $contactInfo = $this->model->getTutorInfo($_SESSION['tutor_id']);
        $profileData = array_merge($profileData, $contactInfo);
        $profileData['subjects'] = $this->model->getTutorSubjects($_SESSION['tutor_id']);
        $profileData['grades'] = $this->model->getTutorGrades($_SESSION['tutor_id']);
        }

        // Pass data to the view
        require_once __DIR__ . '/../../Views/tutor/publicprofile.php';
    }

    public function ShowEditprofile() {

        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
        }

        $profileData = [];
        $contactInfo = [];

        if (isset($_SESSION['tutor_id'])) {
        $profileData = $this->model->getProfileByTutorId($_SESSION['tutor_id']);
        $contactInfo = $this->model->getTutorInfo($_SESSION['tutor_id']);
        $profileData = array_merge($profileData, $contactInfo);
        $profileData['subjects'] = $this->model->getTutorSubjects($_SESSION['tutor_id']);
        $profileData['grades'] = $this->model->getTutorGrades($_SESSION['tutor_id']);
        $allSubjects = $this->model->getAllSubjects(); 
        }
    
        include '../src/views/tutor/editprofile.php';
    }

    public function ShowUpdatedprofile() {
        //session_start(); // Ensure session is started
    
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'tutor_id' => htmlspecialchars($_SESSION['tutor_id']),
                'tutor_first_name' => htmlspecialchars($_POST['tutor_first_name'] ?? ''),
                'tutor_last_name' => htmlspecialchars($_POST['tutor_last_name'] ?? ''),
                'bio' => htmlspecialchars($_POST['bio'] ?? ''),
                'education' => htmlspecialchars($_POST['education'] ?? ''),
                'specialization' => htmlspecialchars($_POST['specialization'] ?? ''),
                'experience' => htmlspecialchars($_POST['experience'] ?? ''),
                'country' => htmlspecialchars($_POST['country'] ?? ''),
                'city_town' => htmlspecialchars($_POST['city_town'] ?? ''),
                'tutor_contact_number' => htmlspecialchars($_POST['tutor_contact_number'] ?? ''),
                'tutor_email' => htmlspecialchars($_POST['tutor_email'] ?? ''),
                'tutor_DOB' => htmlspecialchars($_POST['tutor_DOB'] ?? ''),
                'tutor_NIC' => htmlspecialchars($_POST['tutor_NIC'] ?? '')
            ];
    
            // Profile photo handling
            $uploadDir = './images/tutor_uploads/tutor_profile_photos/';
            if (isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] === UPLOAD_ERR_OK) {
                $fileName = basename($_FILES['profile-image']['name']);
                $uploadPath = $uploadDir . $fileName;
    
                if (move_uploaded_file($_FILES['profile-image']['tmp_name'], $uploadPath)) {
                    $data['tutor_profile_photo'] = $fileName;
                    $_SESSION['profile_picture'] = $fileName;
                } else {
                    $_SESSION['error'] = 'File upload failed';
                    $data['tutor_profile_photo'] = $_POST['existing_profile_photo'] ?? 'profile1.jpg';
                }
            } else {
                // Use the existing photo if no new image is uploaded
                $data['tutor_profile_photo'] = $_POST['existing_profile_photo'] ?? 'profile1.jpg';
            }
    
            try {
                $exist = $this->model->checkid($data['tutor_id']);
                if ($exist) {
                    $this->model->updateProfile($data);
                } else {
                    $this->model->createProfile($data);
                }
    
                $subjects = $_POST['subjects'] ?? [];
                $grades = $_POST['grades'] ?? [];
    
                $this->model->updateTutorSubjects($_SESSION['tutor_id'], $subjects);
                $this->model->updateTutorGrades($_SESSION['tutor_id'], $grades);
    
                // Redirect after successful update
                header('Location: /tutor-public-profile?success=Profile Update Successful');
                exit();
    
            } catch (\Exception $e) {
                echo "Error creating profile: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method. Please use POST to create a profile.";
        }
    }
    

    public function DeleteProfile() {

        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->model->deleteProfile($_SESSION['tutor_id']);
                header('Location: /tutor-logout'); // Redirect to logout
                exit();
            } catch (\Exception $e) {
                echo "Error deleting profile: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method. Please use POST to delete a profile.";
        }
    }


    
}