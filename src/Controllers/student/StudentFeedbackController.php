<?php
namespace App\Controllers\student;

use App\Models\student\FeedbackModel;

class StudentFeedbackController {
    private $model;
    private $tutors;
    private $feedbacks;
    private $student_id;

    public function __construct() {
        $this->model = new FeedbackModel();
        
        // Get student ID from session
        $this->student_id = $_SESSION['student_id'] ?? null;
        
        if ($this->student_id) {
            $this->tutors = $this->model->get_completed_session_tutors($this->student_id);
            $this->feedbacks = $this->model->get_student_feedback($this->student_id);
        } else {
            $this->tutors = [];
            $this->feedbacks = [];
        }
    }

    public function showFeedback() {
        $tutors = $this->tutors;
        $feedbacks = $this->feedbacks;
        $student_id = $this->student_id;
        
        include '../src/Views/student/feedback.php';
    }

    public function submitFeedback() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /student-feedback");
            exit;
        }
        
        if (!$this->student_id) {
            $_SESSION['error'] = "You must be logged in to submit feedback.";
            header("Location: /login");
            exit;
        }
        
        $session_id = $_POST['session_id'] ?? null;
        $student_feedback = $_POST['student_feedback'] ?? null;
        $session_rating = $_POST['session_rating'] ?? null;
        
        if (!$session_id || !$student_feedback || !$session_rating) {
            $_SESSION['error'] = "All fields are required.";
            header("Location: /student-feedback");
            exit;
        }
        
        // Verify session ownership
        if (!$this->model->verify_session_ownership($session_id, $this->student_id)) {
            $_SESSION['error'] = "You can only provide feedback for your own sessions.";
            header("Location: /student-feedback");
            exit;
        }
        
        // Check if feedback already exists
        if ($this->model->check_existing_feedback($session_id)) {
            $_SESSION['error'] = "You have already provided feedback for this session.";
            header("Location: /student-feedback");
            exit;
        }
        
        // Save feedback
        $success = $this->model->save_comment(
            $this->student_id,
            $session_id,
            $student_feedback,
            $session_rating
        );
        
        if ($success) {
            $_SESSION['success'] = "Your feedback has been submitted successfully.";
        } else {
            $_SESSION['error'] = "Failed to submit feedback. Please try again.";
        }
        
        header("Location: /student-feedback");
        exit;
    }

    public function updateFeedback() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /student-feedback");
            exit;
        }
        
        if (!$this->student_id) {
            $_SESSION['error'] = "You must be logged in to update feedback.";
            header("Location: /login");
            exit;
        }
        
        $feedback_id = $_POST['feedback_id'] ?? null;
        $student_feedback = $_POST['student_feedback'] ?? null;
        $session_rating = $_POST['session_rating'] ?? null;
        
        if (!$feedback_id || !$student_feedback || !$session_rating) {
            $_SESSION['error'] = "All fields are required.";
            header("Location: /student-feedback");
            exit;
        }
        
        // Verify feedback ownership
        if (!$this->model->verify_feedback_ownership($feedback_id, $this->student_id)) {
            $_SESSION['error'] = "You can only modify your own feedback.";
            header("Location: /student-feedback");
            exit;
        }
        
        // Update feedback
        $success = $this->model->update_comment(
            $feedback_id,
            $student_feedback,
            $session_rating
        );
        
        if ($success) {
            $_SESSION['success'] = "Your feedback has been updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update feedback. Please try again.";
        }
        
        header("Location: /student-feedback");
        exit;
    }

    public function deleteFeedback() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /student-feedback");
            exit;
        }
        
        if (!$this->student_id) {
            $_SESSION['error'] = "You must be logged in to delete feedback.";
            header("Location: /login");
            exit;
        }
        
        $feedback_id = $_POST['feedback_id'] ?? null;
        
        if (!$feedback_id) {
            $_SESSION['error'] = "Invalid feedback ID.";
            header("Location: /student-feedback");
            exit;
        }
        
        // Verify feedback ownership
        if (!$this->model->verify_feedback_ownership($feedback_id, $this->student_id)) {
            $_SESSION['error'] = "You can only delete your own feedback.";
            header("Location: /student-feedback");
            exit;
        }
        
        // Delete feedback
        $success = $this->model->delete_comment($feedback_id);
        
        if ($success) {
            $_SESSION['success'] = "Your feedback has been deleted successfully.";
        } else {
            $_SESSION['error'] = "Failed to delete feedback. Please try again.";
        }
        
        header("Location: /student-feedback");
        exit;
    }
}