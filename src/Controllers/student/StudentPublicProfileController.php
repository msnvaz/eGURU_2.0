<?php

namespace App\Controllers\student;

use App\Models\student\ProfileModel;

class StudentPublicProfileController {
    private $model;

    public function __construct() {
        $this->model = new ProfileModel();
    }

    public function ShowPublicprofile() {
        $profileData = $this->model->getProfileByStudentId($_SESSION['student_id']);
        $contactInfo = $this->model->getStudentContactInfo($_SESSION['student_id']);
        $profileData = array_merge($profileData, $contactInfo);

        include '../src/views/student/viewprofile.php';
    }

    public function ShowEditprofile() {
        $profileData = $this->model->getProfileByStudentId($_SESSION['student_id']);
        $contactInfo = $this->model->getStudentContactInfo($_SESSION['student_id']);
        $profileData = array_merge($profileData, $contactInfo);
    
        include '../src/views/student/profile.php';
    }

    public function ShowUpdatedprofile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'student_id' => htmlspecialchars($_SESSION['student_id']),
                'bio' => htmlspecialchars($_POST['bio']),
                'education' => htmlspecialchars($_POST['education']),
                'interests' => htmlspecialchars($_POST['interests']),
                'country' => htmlspecialchars($_POST['country']),
                'city_town' => htmlspecialchars($_POST['city_town']),
                'grade' => htmlspecialchars($_POST['grade']),
                'student_grade' => htmlspecialchars($_POST['grade']),
                'student_profile_photo' => htmlspecialchars($_POST['student_profile_photo'])
            ];
    
            if (isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] == 0) {
                $uploadDir = 'images/student-uploads/profilePhotos/';
                $fileName = uniqid() . '_' . basename($_FILES['profile-image']['name']);
                $uploadPath = $uploadDir . $fileName;
    
                if (move_uploaded_file($_FILES['profile-image']['tmp_name'], $uploadPath)) {
                    $data['student_profile_photo'] = $fileName;
                    $_SESSION['profile_picture'] = $fileName; // Update session with new profile picture
                } else {
                    $_SESSION['error'] = 'File upload failed';
                }
            } else {
                $data['student_profile_photo'] = $_SESSION['profile_picture']; // Use existing profile picture
            }
    
            try {
                $exist = $this->model->checkid($data['student_id']);
                if ($exist) {
                    $this->model->updateProfile($data);
                } else {
                    $this->model->createProfile($data);
                }
    
                // Update the student_grade in the student table
                $this->model->updateStudentGrade($data['student_id'], $data['grade']);
    
                header('Location: /student-publicprofile');
                exit();
    
            } catch (\Exception $e) {
                echo "Error creating profile: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method. Please use POST to create a profile.";
        }
    }

    public function DeleteProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->model->deleteProfile($_SESSION['student_id']);
                header('Location: /student-logout'); // Redirect to logout
                exit();
            } catch (\Exception $e) {
                echo "Error deleting profile: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method. Please use POST to delete a profile.";
        }
    }
}