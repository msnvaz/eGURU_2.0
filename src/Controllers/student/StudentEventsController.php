<?php

namespace App\Controllers\student;

use App\Models\student\EventModel;
use App\Config\Database;

class StudentEventsController {
    private $eventModel;
    private $studentId;

    public function __construct($db = null) {
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        
        if (!isset($_SESSION['student_id'])) {
            header('Location: /student-login');
            exit;
        }
        
        $this->studentId = $_SESSION['student_id'];
        
        
        if ($db === null) {
            $database = new Database();
            $db = $database->connect();
        }
        
        
        $this->eventModel = new EventModel($db);
    }

    
    public function showEvents() {
        
        $upcomingEvents = $this->eventModel->getUpcomingEvents($this->studentId);
        $previousEvents = $this->eventModel->getPreviousEvents($this->studentId);
        
        
        include '../src/Views/student/newevent.php';
    }

    
    public function getEventsByDate() {
        if (!isset($_GET['date'])) {
            echo json_encode(['error' => 'Date parameter is required']);
            return;
        }
        
        $date = $_GET['date'];
        $events = $this->eventModel->getEventsByDate($date, $this->studentId);
        
        header('Content-Type: application/json');
        echo json_encode($events);
    }

    public function getEventDatesInMonth() {
        if (!isset($_GET['month']) || !isset($_GET['year'])) {
            echo json_encode(['error' => 'Month and year parameters are required']);
            return;
        }
    
        $month = (int)$_GET['month'];
        $year = (int)$_GET['year'];
    
        $dates = $this->eventModel->getEventDatesInMonth($month, $year, $this->studentId);
    
        header('Content-Type: application/json');
        echo json_encode($dates);
    }
}