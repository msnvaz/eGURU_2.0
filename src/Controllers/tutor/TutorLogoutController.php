<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;

class TutorLogoutController {
    private $model;

    public function __construct() {
        $this->model = new TutorDetailsModel();
    }

    public function logout() {
        session_start(); // Start the session

        if (isset($_SESSION['tutor_id'])) {
            $tutorId = $_SESSION['tutor_id'];
            // Update tutor_log to 'offline'
            $this->model->updateTutorLogStatus($tutorId, 'offline');
        }

        session_unset(); // Clear all session variables
        session_destroy(); // Destroy the session
        header("Location: /tutor-login"); // Redirect to the login page
        exit;
    }
}
