<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;

class TutorLogoutController {
    private $model;

    public function __construct() {
        $this->model = new TutorDetailsModel();
    }

    public function logout() {
        

        if (isset($_SESSION['tutor_id'])) {
            $tutorId = $_SESSION['tutor_id'];
            
            $this->model->updateTutorLogStatus($tutorId, 'offline');
        }

        session_unset(); 
        session_destroy();
        header("Location: /tutor-login");
        exit;
    }
}
