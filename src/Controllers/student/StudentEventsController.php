<?php

namespace App\Controllers\student;

use App\Models\student\EventModel;
use App\Config\Database;

class StudentEventsController {
    private $eventModel;
    private $studentId;

    public function __construct($db = null) {
        // Start session if not started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if student is logged in
        if (!isset($_SESSION['student_id'])) {
            header('Location: /student-login');
            exit;
        }
        
        $this->studentId = $_SESSION['student_id'];
        
        // If no database connection is provided, create one
        if ($db === null) {
            $database = new Database();
            $db = $database->connect();
        }
        
        // Use the provided or created database connection
        $this->eventModel = new EventModel($db);
    }

    /**
     * Main method to display the events page
     */
    public function showEvents() {
        // Get upcoming and previous events
        $upcomingEvents = $this->eventModel->getUpcomingEvents($this->studentId);
        $previousEvents = $this->eventModel->getPreviousEvents($this->studentId);
        
        // Include the view file
        include '../src/Views/student/newevent.php';
    }

    /**
     * AJAX method to get events for a specific date
     */
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