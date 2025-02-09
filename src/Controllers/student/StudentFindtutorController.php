<?php

namespace App\Controllers\student;

use App\Models\student\TutorModel;  // Updated to match your actual model name

class StudentFindtutorController {
    private $model;

    public function __construct() {  // Fixed constructor name
        $this->model = new TutorModel();
    }
    
    public function ShowFindtutor() {
        require_once '../src/Views/student/findtutor.php';
    }

    public function getTutorById($id) {
        if (!is_numeric($id)) {
            echo json_encode(['error' => 'Invalid ID']);
            return;
        }
        
        $tutor = $this->model->fetchTutorById($id);
        if ($tutor) {
            echo json_encode($tutor);
        } else {
            echo json_encode(['error' => 'Tutor not found']);
        }
    }

    public function searchTutors() {
        // Debug POST data
        error_log("Raw POST data: " . print_r($_POST, true));
    
        $grade = isset($_POST['grade']) ? $_POST['grade'] : '';
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        $experience = isset($_POST['experience']) ? $_POST['experience'] : '';
    
        // Debug filtered data
        error_log("Filtered data - Grade: '$grade', Subject: '$subject', Experience: '$experience'");
    
        $tutors = $this->model->searchTutors($grade, $subject, $experience);
        
        // Debug results
        error_log("Number of tutors found: " . count($tutors));
        
        echo json_encode($tutors);
    }

    public function requestTutor() {
        if (!isset($_SESSION['student_id'])) {
            echo json_encode(array('success' => false, 'message' => 'Please login first'));
            return;
        }
    
        $tutorId = isset($_POST['tutor_id']) ? $_POST['tutor_id'] : '';
        $preferredTime = isset($_POST['preferred_time']) ? $_POST['preferred_time'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
    
        if (!$tutorId || !$preferredTime || !$message) {
            echo json_encode(array('success' => false, 'message' => 'Missing required fields'));
            return;
        }
    
        try {
            $result = $this->model->createTutorRequest([
                'student_id' => $_SESSION['student_id'],
                'tutor_id' => $tutorId,
                'preferred_time' => $preferredTime,
                'message' => $message,
                'status' => 'pending'
            ]);
    
            if ($result) {
                // Send success response
                echo json_encode(['success' => true, 'message' => 'Request sent successfully!']);
            } else {
                // Send failure response
                echo json_encode(['success' => false, 'message' => 'Failed to send request.']);
            }
            exit();
            
        } catch (Exception $e) {
            echo json_encode(array('success' => false, 'message' => 'Failed to send request'));
        }
    }}