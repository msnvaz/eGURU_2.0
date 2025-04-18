<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;
use App\Models\tutor\SessionsModel;

class TutorEventController {
    private $tutordetailsmodel;
    private $sessionsmodel;

    public function __construct() {
        $this->tutordetailsmodel = new TutorDetailsModel();
        $this->sessionsmodel = new SessionsModel();
    }

    /**
     * Displays the student login page with a list of students.
     */
    public function showEventPage() {

        session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
    
        $tutorData = null;
    
        $upcomingEvents = [];
        $previousEvents = [];
    
        // Fetch tutor details if tutor_id exists in session
        if (isset($_SESSION['tutor_id'])) {
            $tutorId = $_SESSION['tutor_id'];
            $tutorData = $this->tutordetailsmodel->getTutorDetails($tutorId);
        }
    
        $upcomingEvents = $this->sessionsmodel->getUpcomingEvents($tutorId);
        $previousEvents = $this->sessionsmodel->getPreviousEvents($tutorId);
        // Pass data to the view
        require_once __DIR__ . '/../../Views/tutor/events.php';
    }


    
}