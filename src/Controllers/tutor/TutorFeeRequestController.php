<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorLevelUpgradeModel;


class TutorFeeRequestController {
    private $model;
    

    public function __construct() {
        $this->model = new TutorLevelUpgradeModel();
        
    }

    public function showFeeRequestPage() {
        //session_start();
    
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
    
    
        if (isset($_SESSION['tutor_id'])) {
            $tutorId = $_SESSION['tutor_id'];
        }

        $tutorLevels = null;
        $currentLevel = null;
        $requests = null;

        $tutorLevels = $this->model->getAllTutorLevels();

        $currentLevel = $this->model->getTutorCurrentLevel($tutorId);
    
        $requests = $this->model->getUpgradeRequestsByTutor($tutorId);


        require_once __DIR__ . '/../../Views/tutor/fee_request.php';
    }

    public function submitLevelUpgradeRequest() {
        //session_start();
    
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
    
        $tutorId = $_SESSION['tutor_id'];
        $currentLevel = $this->model->getTutorCurrentLevel($tutorId);
    
        if (isset($_POST['requested_level'], $_POST['request_body'])) {
            $requestedLevel = $_POST['requested_level'];
            $requestBody = $_POST['request_body'];
            $this->model->submitUpgradeRequest($tutorId, $currentLevel, $requestedLevel, $requestBody);
            header("Location: /tutor-fee-request?success=Request Successful");
            exit;
        } else {
            header("Location: /tutor-fee-request?error=Invalid Request");
            exit;   
        }
    }
    
    public function cancelUpgradeRequest() {
        //session_start();
        if (!isset($_SESSION['tutor_id'])) {
            header("Location: /tutor-login");
            exit;
        }
    
        $requestId = $_POST['request_id'] ?? null;
    
        if ($requestId) {
            $this->model->cancelUpgradeRequest($requestId);
        }
    
        header("Location: /tutor-fee-request?success=Request Cancel Successful"); // redirect back to the panel
        exit;
    }
    

}