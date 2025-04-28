<?php

namespace App\Controllers\student;

use App\Models\student\FindTutorModel;

class StudentFindtutorController
{
    private $model;

    public function __construct()
    {
        $this->model = new FindTutorModel();
    }

    
    public function ShowFindtutor()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        $student_id = $_SESSION['student_id'];

        
        $grades = $this->model->getGrades();
        $subjects = $this->model->getSubjects();
        $experiences = $this->model->getExperiences();

        
        $conn = $this->model->getConnection();
        $query = "SELECT time_slot_id, day FROM student_availability WHERE student_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$student_id]);
        $student_availability = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        
        include '../src/Views/student/findtutor.php';
    }

    
    
    public function searchTutors()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
    
        $student_id = $_SESSION['student_id'];
        $grade = $_POST['grade'];
        $subject_id = $_POST['subject'];
        $experience = $_POST['experience'];
    
        
        error_log("Grade: $grade, Subject: $subject_id, Experience: $experience");
    
        
        $tutors = $this->model->searchTutors($grade, $subject_id, $experience, $student_id);
    
        
        error_log("Tutors: " . print_r($tutors, true));
    
        
        $grades = $this->model->getGrades();
        $subjects = $this->model->getSubjects();
        $experiences = $this->model->getExperiences();
    
        
        include '../src/Views/student/findtutor.php';
    }

    
    public function requestTutor()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['tutorId']) || empty($data['tutorId']) || 
            !isset($data['subjectId']) || empty($data['subjectId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data']);
            exit();
        }

        $studentId = $_SESSION['student_id'];
        $tutorId = $data['tutorId'];
        $subjectId = $data['subjectId'];
        
        
        $scheduledDate = isset($data['scheduledDate']) ? $data['scheduledDate'] : null;
        $scheduleTime = isset($data['scheduleTime']) ? $data['scheduleTime'] : null;
        $sessionStatus = ($scheduledDate && $scheduleTime) ? 'scheduled' : 'requested';

        
        $conn = $this->model->getConnection();
        $query = "INSERT INTO session (student_id, tutor_id, scheduled_date, schedule_time, session_status, subject_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt->execute([$studentId, $tutorId, $scheduledDate, $scheduleTime, $sessionStatus, $subjectId])) {
            echo json_encode(['success' => 'Request sent successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to send request']);
        }
    }
    
}