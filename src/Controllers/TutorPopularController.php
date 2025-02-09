<?php

// Include necessary files
require_once 'vendor/autoload.php';
use App\Models\TutorDisplayModel;

class TutorPopular {

    public function getScheduledTutors() {
        // Instantiate the TutorModel class
        $tutorModel = new TutorModel();

        // Fetch the list of tutors with the highest scheduled sessions
        $scheduledTutors = $tutorModel->getScheduledTutors();

        // Include the view and pass the data
        include 'views/tutor-popular.php';  // This file will handle the HTML display
    }
}

// Instantiate and call the controller
$tutorPopular = new TutorPopular();
$tutorPopular->getScheduledTutors();
