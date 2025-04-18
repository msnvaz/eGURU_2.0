<?php

namespace App\Controllers\tutor;

use App\Models\tutor\FeedbackModel;
use App\Config\Database;

class TutorFeedbackController {
    private $feedbackModel;

    public function __construct() {
        $db = new Database();  // Create the Database object inside the constructor
        $this->feedbackModel = new FeedbackModel($db->connect());  // Pass the DB connection to FeedbackModel
    }

    // Fetch feedbacks for the logged-in tutor
    public function showFeedbackPage() {
       // session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
        $tutorId = $_SESSION['tutor_id'];
        $feedbacks = $this->feedbackModel->getFeedbacksByTutor($tutorId);
        // Pass data to the view
        require_once __DIR__ . '/../../Views/tutor/feedback_list.php';
    }

    // Handle reply submission
    public function submitReply() {
        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feedbackId = $_POST['feedback_id'];
            $replyMessage = trim($_POST['reply']);

            if (!empty($replyMessage)) {
                $success = $this->feedbackModel->saveReply($feedbackId, $replyMessage);
                if ($success) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Reply already exists or feedback not found.']);
                }
            }
        }
    }

   public function updateReply() {
    //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(['error' => 'Invalid request method.']);
        return;
    }

    $feedbackId = $_POST['feedback_id'] ?? null;
    $replyMessage = $_POST['reply'] ?? null;

    if (!$feedbackId || !$replyMessage) {
        echo json_encode(['error' => 'Feedback ID and reply message are required.']);
        return;
    }

    if ($this->feedbackModel->updateReply($feedbackId, $replyMessage)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to update reply.']);
    }
}



}
