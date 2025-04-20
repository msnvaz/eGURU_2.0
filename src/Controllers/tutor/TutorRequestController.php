<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;
use App\Models\tutor\SessionsModel;

class TutorRequestController {
    private $model;
    private $sessionModel;

    public function __construct() {
        $this->model = new TutorDetailsModel();
        $this->sessionModel = new SessionsModel(); // ✅ corrected property name
    }

    public function showRequestPage() {
        //session_start();
    
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
    
        $active_requests = [];
        $rejected_requests = [];
    
        if (isset($_SESSION['tutor_id'])) {
            $tutorId = $_SESSION['tutor_id'];
            $active_requests = $this->sessionModel->getRequestedSessionsByTutor($tutorId);
            $rejected_requests = $this->sessionModel->getRejectedSessionsByTutor($tutorId);
        }
    
        require_once __DIR__ . '/../../Views/tutor/request.php';
    }

    public function handleSessionRequest() {
        //session_start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['session_id'], $_POST['action'])) {
            $sessionId = intval($_POST['session_id']);
            $action = $_POST['action'];
    
            if ($action === 'accept') {
                $this->sessionModel->updateSessionStatus($sessionId, 'scheduled');
            } elseif ($action === 'decline') {
                $this->sessionModel->updateSessionStatus($sessionId, 'rejected');
            }
        }
    
        // Redirect back to the request page
        header("Location: /tutor-request");
        exit;
    }
    
    
}
