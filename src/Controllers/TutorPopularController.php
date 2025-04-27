<?php

require_once 'vendor/autoload.php';

use App\Models\TutorDisplayModel;

class TutorPopular {

    public function getScheduledTutors() {
    
        $tutorModel = new TutorDisplayModel();

        $scheduledTutors = $tutorModel->getScheduledTutors();

        include 'views/tutor-popular.php';
    }
}

$tutorPopular = new TutorPopular();
$tutorPopular->getScheduledTutors();
