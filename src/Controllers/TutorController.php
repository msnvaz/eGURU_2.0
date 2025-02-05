<?php

// Include necessary files
require_once 'vendor/autoload.php';
use App\Models\TutorModel;

class TutorController {

    public function getSuccessfulTutors() {
        // Instantiate the TutorModel class
        $tutorModel = new TutorModel();

        // Fetch the list of successful tutors
        $successfulTutors = $tutorModel->getSuccessfulTutors();

        // Include the view and pass the data
        include 'views/tutor-gallery.php';  // This file will handle the HTML display
    }
}

// Instantiate and call the controller
$tutorController = new TutorController();
$tutorController->getSuccessfulTutors();
