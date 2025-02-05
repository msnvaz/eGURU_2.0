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
        session_unset(); // Clear all session variables
        session_destroy(); // Destroy the session
        header("Location: /tutor-login"); // Redirect to the login page
        exit;
    }
}
