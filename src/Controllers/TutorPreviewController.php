<?php


namespace App\Controllers;

use App\Models\TutorPreviewModel;

class TutorPreviewController {

    public function showTutorProfile() {
        $tutor_id = $_GET['tutor_id'] ?? null;

        if (!$tutor_id) {
            die("Error: Tutor ID is required.");
        }

        $tutorModel = new TutorPreviewModel();

        $tutor = $tutorModel->getTutorById($tutor_id);

        if (!$tutor) {
            die("Error: Tutor not found.");
        }

        
        require_once __DIR__ . '/../views/tutorpreview.php';

    }
}

$tutorPreviewController = new TutorPreviewController(); 
$tutorPreviewController->showTutorProfile();
