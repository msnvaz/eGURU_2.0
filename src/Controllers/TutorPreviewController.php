<?php

// Include necessary files
// require_once 'vendor/autoload.php';
namespace App\Controllers;

use App\Models\TutorPreviewModel;

class TutorPreviewController {

    public function showTutorProfile() {
        // Fetch tutor_id from GET parameter
        $tutor_id = $_GET['tutor_id'] ?? null;

        if (!$tutor_id) {
            die("Error: Tutor ID is required.");
        }

        // Instantiate the TutorPreviewModel class
        $tutorModel = new TutorPreviewModel();

        // Fetch tutor details
        $tutor = $tutorModel->getTutorById($tutor_id);

        if (!$tutor) {
            die("Error: Tutor not found.");
        }

        // Include the view and pass the data
        // If 'views' is in the root directory, update the path accordingly.
        require_once __DIR__ . '/../views/tutorpreview.php';

    }
}

// Instantiate and call the controller
$tutorPreviewController = new TutorPreviewController();  // Corrected instantiation
$tutorPreviewController->showTutorProfile();
