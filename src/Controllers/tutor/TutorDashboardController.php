<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;

class TutorDashboardController {
    private $model;

    public function __construct() {
        $this->model = new TutorDetailsModel();
    }

    /**
     * Displays the student login page with a list of students.
     */
    public function showTutorDashboardPage() {
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
          

        // Pass data to the view
        require_once __DIR__ . '/../../Views/tutor/dashboard.php';
    }


    
}