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

        $studentProfilePhoto = $this->model->getStudentProfilePhoto($_SESSION['student_id']);

        $profileData = array_merge($profileData, $contactInfo);

        include '../src/views/student/viewprofile.php';
    }

    public function ShowEditprofile() {
        $profileData = $this->model->getProfileByStudentId($_SESSION['student_id']);
        $contactInfo = $this->model->getStudentContactInfo($_SESSION['student_id']);

        $studentProfilePhoto = $this->model->getStudentProfilePhoto($_SESSION['student_id']);

        $profileData = array_merge($profileData, $contactInfo);
    
        include '../src/views/student/profile.php';
    }

    public function ShowUpdatedprofile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $existingProfileData = $this->model->getProfileByStudentId($_SESSION['student_id']);
            $existingContactInfo = $this->model->getStudentContactInfo($_SESSION['student_id']);
            $existingData = array_merge($existingProfileData ?: [], $existingContactInfo ?: []);
            
            $data = [
                'student_id' => htmlspecialchars($_SESSION['student_id']),
            ];
            
            if (isset($_POST['bio']) && (!isset($existingData['bio']) || $_POST['bio'] !== $existingData['bio'])) {
                $data['bio'] = htmlspecialchars($_POST['bio']);
            }
            
            if (isset($_POST['education']) && (!isset($existingData['education']) || $_POST['education'] !== $existingData['education'])) {
                $data['education'] = htmlspecialchars($_POST['education']);
            }
            
            if (isset($_POST['interests']) && (!isset($existingData['interests']) || $_POST['interests'] !== $existingData['interests'])) {
                $data['interests'] = htmlspecialchars($_POST['interests']);
            }
            
            if (isset($_POST['country']) && (!isset($existingData['country']) || $_POST['country'] !== $existingData['country'])) {
                $data['country'] = htmlspecialchars($_POST['country']);
            }
            
            if (isset($_POST['city_town']) && (!isset($existingData['city_town']) || $_POST['city_town'] !== $existingData['city_town'])) {
                $data['city_town'] = htmlspecialchars($_POST['city_town']);
            }
            
            if (isset($_POST['grade']) && (!isset($existingData['student_grade']) || $_POST['grade'] != $existingData['student_grade'])) {
                $data['student_grade'] = htmlspecialchars($_POST['grade']);
            }
    
            $photoUpdated = false;
            if (isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] == 0) {
                $uploadDir = 'images/student-uploads/profilePhotos/';
                $fileName = uniqid() . '_' . basename($_FILES['profile-image']['name']);
                $uploadPath = $uploadDir . $fileName;
    
                if (move_uploaded_file($_FILES['profile-image']['tmp_name'], $uploadPath)) {
                    $data['student_profile_photo'] = $fileName;
                    $_SESSION['profile_picture'] = $fileName;
                    $photoUpdated = true;
                } else {
                    $_SESSION['error'] = 'File upload failed';
                }
            }
    
            try {
                $exist = $this->model->checkid($data['student_id']);
                if ($exist) {
                    $this->model->updateChangedFields($data, $photoUpdated);
                } else {
                    $this->model->createProfile($data);
                }
    
                if (isset($data['student_grade'])) {
                    $this->model->updateStudentGrade($data['student_id'], $data['student_grade']);
                }
    
                header('Location: /student-publicprofile');
                exit();
    
            } catch (\Exception $e) {
                echo "Error updating profile: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method. Please use POST to update a profile.";
        }
    }

    public function DeleteProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $this->model->deleteProfile($_SESSION['student_id']);
                header('Location: /student-logout'); 
                exit();
            } catch (\Exception $e) {
                echo "Error deleting profile: " . $e->getMessage();
            }
        } else {
            echo "Invalid request method. Please use POST to delete a profile.";
        }
    }
}