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

   
    public function showEventPage()
{
    

    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: /tutor-login");
        exit;
    }

    $tutorData = null;
    $upcomingEvents = [];
    $previousEvents = [];

    if (isset($_SESSION['tutor_id'])) {
        $tutorId = $_SESSION['tutor_id'];
        $tutorData = $this->tutordetailsmodel->getTutorDetails($tutorId);

        
        $this->sessionsmodel->updateCompletedSessionsAndPayments();
        $this->sessionsmodel->cancelExpiredRequestedSessions();

        $upcomingEvents = $this->sessionsmodel->getUpcomingEvents($tutorId);
        $previousEvents = $this->sessionsmodel->getPreviousEvents($tutorId);

    }

    require_once __DIR__ . '/../../Views/tutor/events.php';
}

    public function getEventsByDate() {

        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
        if (!isset($_GET['date'])) {
            echo json_encode(['error' => 'Date parameter is required']);
            return;
        }
        
        $date = $_GET['date'];
        $events = $this->sessionsmodel->getEventsByDate($date, $_SESSION['tutor_id']);
        
        header('Content-Type: application/json');
        echo json_encode($events);
    }

    public function getEventDatesInMonth() {

        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
        if (!isset($_GET['month']) || !isset($_GET['year'])) {
            echo json_encode(['error' => 'Month and year parameters are required']);
            return;
        }
    
        $month = (int)$_GET['month'];
        $year = (int)$_GET['year'];

    
        $dates = $this->sessionsmodel->getEventDatesInMonth($month, $year, $_SESSION['tutor_id']);
    
        header('Content-Type: application/json');
        echo json_encode($dates);
    }

    public function cancelSession($sessionId) {
        //session_start();
        
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
    
        try {
            $result = $this->sessionsmodel->updateSessionStatus($sessionId, "cancelled");
    
        } catch (\Exception $e) {
            header("Location: /tutor-event?error=Session Cancelation Failed"); 
            exit;
        }
    
        header("Location: /tutor-event?success=Session Cancelation Successful"); 
        exit;
    }
    


    
}