<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;
use App\Models\tutor\SessionsModel;
use App\Models\tutor\FeedbackModel;


class TutorDashboardController {
    private $tutordetailsmodel;
    private $sessionsmodel;
    private $feedbackmodel;

    public function __construct() {
        $this->tutordetailsmodel = new TutorDetailsModel();
        $this->sessionsmodel = new SessionsModel();
        $this->feedbackmodel = new FeedbackModel();
    }

    
    public function showTutorDashboardPage() {
        
    

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
    
    $tutorData = null;
    $upcomingEvents = [];
    $previousEvents = [];
    $tutorFeedback = [];
    $tutorRating = null;

    
    if (isset($_SESSION['tutor_id'])) {
        $tutorId = $_SESSION['tutor_id'];
        $tutorData = $this->tutordetailsmodel->getTutorDetails($tutorId);
        $upcomingEvents = $this->sessionsmodel->getUpcomingEvents($tutorId);
        $previousEvents = $this->sessionsmodel->getPreviousEvents($tutorId);
        $tutorFeedback = $this->feedbackmodel->getFeedbacksByTutor($tutorId);
        $tutorRating = $this->feedbackmodel->getRatingByTutor($tutorId);
    }

    

        
        require_once __DIR__ . '/../../Views/tutor/dashboard.php';
    }


    
}