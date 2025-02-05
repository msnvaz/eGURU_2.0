<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;

class TutorFeedbackController {
    private $model;

    public function __construct() {
        $this->model = new TutorDetailsModel();
    }

    /**
     * Displays the student login page with a list of students.
     */
    public function showFeedbackPage() {
        // Fetch all studentss from the database
        //$ads = $this->model->getALLStudents();

        // Pass data to the view
        require_once __DIR__ . '/../../Views/tutor/tutor_reply.php';
    }


    
}