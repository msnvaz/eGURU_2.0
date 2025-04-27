<?php

require_once 'vendor/autoload.php';
use App\Models\TutorDisplayModel;

class TutorActiveController {

    public function getSuccessfulTutors() {
        $tutorModel = new TutorDisplayModel();

        $successfulTutors = $tutorModel->getSuccessfulTutors();

        include 'views/tutor-active.php';  
    }
}

$tutorController = new TutorActiveController();
$tutorController->getSuccessfulTutors();
