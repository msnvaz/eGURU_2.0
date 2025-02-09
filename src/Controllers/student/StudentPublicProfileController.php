<?php

namespace App\Controllers\student;

use App\Models\student\ProfileModel; // Make sure the correct model is imported

class StudentPublicProfileController {
    private $model;

    public function __construct() {
        // Initialize the ProfileModel class
        $this->model = new ProfileModel();  // Use ProfileModel, not Profile
    }

    // Method to update the profile data
    // public function updateProfile() {
    //     $data = [
    //         'student_id' => $_SESSION['student_id'],
    //         'name' => $_SESSION['name'],
    //         'bio' => $_POST['bio'],
    //         'education' => $_POST['education'],
    //         'phone' => $_POST['phone'],
    //         'email' => $_POST['email'],
    //         'interests' => $_POST['interests'],
    //         'country' => $_POST['country'],
    //         'city_town' => $_POST['city_town'],
    //         'grade' => $_POST['grade'],
    //     ];

        

    //     // Update the profile in the database using the model
    //     $this->model->updateProfile($data);  // Call the updateProfile method from the model

    //     // Redirect after successful update
    //     header('Location: /student-publicprofile');
    //     exit();
    // }

    // Method to show the public profile
    public function ShowPublicprofile() {
        // Fetch profile data from the model
        $profileData = $this->model->getProfileByStudentId($_SESSION['student_id']);  // Use the model to fetch profile data

        // Render the profile view
        include '../src/views/student/viewprofile.php';  // Adjust the path if necessary
    }
    public function ShowEditprofile() {
        // Fetch profile data from the model
        $profileData = $this->model->getProfileByStudentId($_SESSION['student_id']);  // Use the model to fetch profile data

        // Render the profile view
        include '../src/views/student/profile.php';  // Adjust the path if necessary
    }
    

    // Method to handle profile creation
    public function ShowUpdatedprofile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input data
            $data = [
                'student_id' => htmlspecialchars($_SESSION['student_id']),
                'name' => htmlspecialchars($_SESSION['student_name']),
                'bio' => htmlspecialchars($_POST['bio']),
                'education' => htmlspecialchars($_POST['education']),
                'phone' => htmlspecialchars($_POST['phone']),
                'email' => htmlspecialchars($_POST['email']),
                'interests' => htmlspecialchars($_POST['interests']),
                'country' => htmlspecialchars($_POST['country']),
                'city_town' => htmlspecialchars($_POST['city_town']),
                'grade' => htmlspecialchars($_POST['grade']),
            ];

            // Handle profile picture upload first
            if (isset($_FILES['profile-image']) && $_FILES['profile-image']['error'] == 0) {
                $uploadDir = 'images/student-uploads/profilePhotos/';
                $fileName = uniqid() . '_' . basename($_FILES['profile-image']['name']);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['profile-image']['tmp_name'], $uploadPath)) {
                    $data['profile_picture'] = $fileName;
                } else {
                    $_SESSION['error'] = 'File upload failed';
                }
            }
        
            try {
                // Call the model's createProfile method
                $exist = $this->model->checkid($data['student_id']);
                if($exist){
                    $this->model->updateProfile($data);
                }else{
                    $this->model->createProfile($data);
                }   
                

                // Redirect or display a success message
                header('Location: /student-publicprofile');
                exit();
                
            } catch (\Exception $e) {
                // Handle errors
                echo "Error creating profile: " . $e->getMessage();
            }
        } else {
            // Handle non-POST requests (e.g., show a form)
            echo "Invalid request method. Please use POST to create a profile.";
        }
    }
}   