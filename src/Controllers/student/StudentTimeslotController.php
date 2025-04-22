<?php

namespace App\Controllers\student;

use App\Models\student\TimeslotModel;

class StudentTimeslotController {
    private $model;

    public function __construct() {
        $this->model = new TimeslotModel();
    }

    /**
     * Display the student timeslot selection page.
     */
    public function showStudentTimeSlotPage() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the student ID is set in the session
        if (!isset($_SESSION['student_id'])) {
            // Redirect to login page if student ID is not set
            header("Location: /student-login");
            exit;
        }

        $studentId = $_SESSION['student_id'];

        // Fetch all available timeslots and the student's selected timeslots
        $allTimeSlots = $this->model->getAllTimeSlots();
        $selectedSlots = $this->model->getStudentTimeSlots($studentId);

        // Include the view file for displaying timeslots
        require_once __DIR__ . '/../../Views/student/timeslot.php';
    }

    /**
     * Save the student's selected timeslots.
     */
    public function saveStudentTimeSlots() {
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if the student ID is set in the session
        if (!isset($_SESSION['student_id'])) {
            // Redirect to login page if student ID is not set
            header("Location: /student-login");
            exit;
        }

        $studentId = $_SESSION['student_id'];
        $slotSelections = [];

        // Define the days of the week
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Loop through days and extract selections from POST data
        foreach ($days as $day) {
            if (!empty($_POST[$day])) {
                $slotSelections[$day] = $_POST[$day];  // $day => [slot_ids]
            }
        }

        // Save the selected timeslots to the database
        $this->model->saveStudentTimeSlots($studentId, $slotSelections);

        // Redirect back to the timeslot page with a success message
        header("Location: /student-timeslot?success=1");
        exit;
    }
}