<?php

namespace App\Controllers\student;

use App\Models\student\StudentTutorRequestFormModel;

class StudentTutorRequestFormController {
    private $model;

    public function __construct() {
        $this->model = new StudentTutorRequestFormModel();
    }

    /**
     * Display the tutor request form page.
     *
     * @param int|null $id Tutor ID from URL parameter or GET parameter.
     */
    public function showTutorRequestForm($id = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        $student_id = $_SESSION['student_id'];
        
        // Explicitly debug the incoming ID parameter
        error_log("URL parameter id: " . var_export($id, true));
        
        // Get tutor ID from URL parameter, then try GET parameter as fallback
        $tutor_id = null;
        
        if ($id !== null && is_numeric($id)) {
            $tutor_id = intval($id);
        } else if (isset($_GET['tutor_id']) && is_numeric($_GET['tutor_id'])) {
            $tutor_id = intval($_GET['tutor_id']);
        }

        // Debug log to check the processed tutor_id
        error_log("Processed tutor_id: " . var_export($tutor_id, true));

        if (!$tutor_id) {
            error_log("No valid tutor_id found in request. Redirecting to findtutor.");
            header("Location: /student-findtutor");
            exit();
        }

        // Fetch tutor details and available time slots
        $timeSlots = $this->model->getAvailableTimeSlots($tutor_id, $student_id);
        $tutorSubjects = $this->model->getTutorSubjects($tutor_id);

        // Debug log for data fetched from the database
        error_log("Time slots fetched: " . count($timeSlots));
        error_log("Tutor subjects fetched: " . count($tutorSubjects));

        // Check if tutor data exists
        if (empty($tutorSubjects)) {
            // No data found for this tutor
            error_log("No tutor subject data found. Redirecting to findtutor.");
            header("Location: /student-findtutor");
            exit();
        }

        // Organize time slots by day for easier display
        $timeSlotsByDay = [];
        if (!empty($timeSlots)) {
            foreach ($timeSlots as $slot) {
                $day = $slot['day'];
                if (!isset($timeSlotsByDay[$day])) {
                    $timeSlotsByDay[$day] = [];
                }
                $timeSlotsByDay[$day][] = $slot;
            }
            
            // Extract tutor information from the time slots
            $tutorInfo = [
                'tutor_id' => $timeSlots[0]['tutor_id'],
                'tutor_first_name' => $timeSlots[0]['tutor_first_name'],
                'tutor_last_name' => $timeSlots[0]['tutor_last_name']
            ];
        } else {
            // If no time slots, extract tutor info from subjects data
            $tutorInfo = [
                'tutor_id' => $tutorSubjects[0]['tutor_id'],
                'tutor_first_name' => $tutorSubjects[0]['tutor_first_name'],
                'tutor_last_name' => $tutorSubjects[0]['tutor_last_name']
            ];
        }

        // Extract unique subjects from the tutor data
        $subjects = [];
        $tutorLevel = '';
        $hourlyRate = 0;

        foreach ($tutorSubjects as $subjectData) {
            // Store subject_id as key and subject_name as value
            $subjects[$subjectData['subject_id']] = $subjectData['subject_name'];
            $tutorLevel = $subjectData['tutor_level']; 
            $hourlyRate = $subjectData['tutor_pay_per_hour']; 
        }

        // Pass tutor details to the view
        include '../src/Views/student/tutor_request_form.php';
    }

    /**
     * Process the tutor request form submission.
     */
    public function processTutorRequest() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'You must be logged in to request a tutor.']);
            exit();
        }

        // Check if request is POST and has the required data
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            exit();
        }

        try {
            // Get form data
            $student_id = $_SESSION['student_id'];
            $tutor_id = $_POST['tutor_id'] ?? null;
            $subject_id = $_POST['subject_id'] ?? null;
            $time_slot_id = $_POST['time_slot_id'] ?? null;
            $day = $_POST['day'] ?? null;
            $scheduled_date = $_POST['scheduled_date'] ?? null;
            $schedule_time = $_POST['schedule_time'] ?? null;

            // Log received data for debugging
            error_log("Received form data for tutor request: " . json_encode($_POST));

            // Validate required fields
            if (!$tutor_id || !$subject_id || !$time_slot_id) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Please select a subject and time slot.']);
                exit();
            }

            // Always set status to requested as required
            $session_status = 'requested';

            // Insert the session request into the database
            $result = $this->model->insertSession(
                $student_id,
                $tutor_id,
                $scheduled_date,
                $schedule_time,
                $session_status,
                $subject_id
            );

            // Return appropriate response
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Tutor request sent successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to send tutor request. Database could not process the submission.']);
            }
            exit();
        } catch (\Exception $e) {
            error_log("Error in processTutorRequest: " . $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
            exit();
        }
    }
}