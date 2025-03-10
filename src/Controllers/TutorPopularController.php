<?php

// Include necessary files
require_once 'vendor/autoload.php';

use App\Models\TutorDisplayModel;

class TutorPopular {

    public function getScheduledTutors() {
        // Instantiate the TutorDisplayModel class
        $tutorModel = new TutorDisplayModel();

        // Fetch the list of tutors with the highest scheduled sessions
        $scheduledTutors = $tutorModel->getScheduledTutors();

        // Pass data to the view
        include 'views/tutor-popular.php';
    }
}

// Instantiate and call the controller
$tutorPopular = new TutorPopular();
$tutorPopular->getScheduledTutors();
