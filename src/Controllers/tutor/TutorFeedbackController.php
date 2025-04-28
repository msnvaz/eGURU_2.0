<?php

namespace App\Controllers\tutor;

use App\Models\tutor\FeedbackModel;
use App\Config\Database;

class TutorFeedbackController {
    private $feedbackModel;

    public function __construct() {
        $db = new Database();  
        $this->feedbackModel = new FeedbackModel($db->connect());  
    }

    
    public function showFeedbackPage() {
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        $tutorId = $_SESSION['tutor_id'];
        $feedbacks = $this->feedbackModel->getFeedbacksByTutor($tutorId);
        
        require_once __DIR__ . '/../../Views/tutor/feedback_list.php';
    }

    
    public function submitReply() {
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $feedbackId = $_POST['feedback_id'] ?? null;
            $replyMessage = trim($_POST['reply'] ?? '');

            if (empty($feedbackId) || empty($replyMessage)) {
                header("Location: /tutor-feedback?error=Reply cannot be empty.");
                exit;
            }

            $success = $this->feedbackModel->saveReply($feedbackId, $replyMessage);

            if ($success) {
                header("Location: /tutor-feedback?success=Reply saved successfully");
            } else {
                header("Location: /tutor-feedback?error=Failed to save reply.");
            }
        } else {
            header("Location: /tutor-feedback?error=Invalid request method.");
        }
    }

    
    public function updateReply() {
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /tutor-feedback?error=Invalid request method.");
            exit;
        }

        $feedbackId = $_POST['feedback_id'] ?? null;
        $replyMessage = $_POST['reply'] ?? null;

        if (!$feedbackId || !$replyMessage) {
            header("Location: /tutor-feedback?error=Feedback ID and reply message are required.");
            exit;
        }

        if ($this->feedbackModel->updateReply($feedbackId, $replyMessage)) {
            header("Location: /tutor-feedback?success=Reply updated successfully");
        } else {
            header("Location: /tutor-feedback?error=Failed to update reply.");
        }
    }
}
