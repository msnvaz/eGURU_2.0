<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorStudentProfileModel;

class TutorStudentProfileController {
    private $model;
    private $feedbackmodel;

    public function __construct() {
        $this->model = new TutorStudentProfileModel();

    }

    public function showTutorStudentProfile($studentId) {
        $profileData = $this->model->getProfileByStudentId($studentId);
        $contactInfo = $this->model->getStudentContactInfo($studentId); 
        $profileData = array_merge($profileData, $contactInfo);
    
        include '../src/Views/tutor/studentprofile.php';
    }
    
}