<?php

namespace App\Controllers\student;
use App\Models\student\StudentInboxModel;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class StudentInboxController {
    private $model;

    public function __construct() {
        $this->model = new StudentInboxModel();
    }

    // Show inbox page with list of messages
    public function showInbox() {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        
        // Set active tab based on status
        if ($status === 'archived') {
            $activeTab = 'archived';
        } else {
            $activeTab = 'inbox';
        }
        
        // Handle search form submission
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        // Get messages based on filters
        $studentId = $_SESSION['student_id']; // Get current student's ID
        $messages = $this->model->getAllMessages($studentId, $page, $status, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalMessages($studentId, $status, $filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount($studentId);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/student/StudentInbox.php';
    }
    
    // Show a specific message
    public function showMessage($inboxId) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $studentId = $_SESSION['student_id']; // Get current student's ID
        
        // Get the active message
        $activeMessage = $this->model->getMessage($inboxId, $studentId);
        
        if (!$activeMessage) {
            header('Location: /student-inbox');
            exit();
        }
        
        // Mark message as read if it was unread
        if ($activeMessage['status'] === 'unread') {
            $this->model->markAsRead($inboxId, $studentId);
            // Refresh the message data to get updated status
            $activeMessage = $this->model->getMessage($inboxId, $studentId);
        }
        
        // Get all replies for this message
        $replies = $this->model->getReplies($inboxId, $studentId);
        
        // Get all messages for the sidebar (with same filters as inbox page)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllMessages($studentId, $page, $status, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalMessages($studentId, $status, $filter, $searchTerm);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/student/StudentInbox.php';
    }
    
    // Archive a message
    public function archiveMessage($inboxId) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $studentId = $_SESSION['student_id'];
        
        // Verify the message belongs to this student before archiving
        $message = $this->model->getMessage($inboxId, $studentId);
        if (!$message) {
            header('Location: /student-inbox');
            exit();
        }
        
        $this->model->archiveMessage($inboxId);
        header('Location: /student-inbox-message/' . $inboxId);
        exit();
    }
    
    // Unarchive a message
    public function unarchiveMessage($inboxId) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $studentId = $_SESSION['student_id'];
        
        // Verify the message belongs to this student before unarchiving
        $message = $this->model->getMessage($inboxId, $studentId);
        if (!$message) {
            header('Location: /student-inbox');
            exit();
        }
        
        $this->model->unarchiveMessage($inboxId);
        header('Location: /student-inbox-message/' . $inboxId);
        exit();
    }
    
    public function replyToMessage($inboxId) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        if (!isset($_POST['reply_message']) || empty($_POST['reply_message'])) {
            header('Location: /student-inbox-message/' . $inboxId . '?error=Reply message is required');
            exit();
        }
        
        $studentId = $_SESSION['student_id'];
        $replyMessage = $_POST['reply_message'];
        
        // Verify the message belongs to this student before replying
        $message = $this->model->getMessage($inboxId, $studentId);
        if (!$message) {
            header('Location: /student-inbox');
            exit();
        }
        
        if ($this->model->addReply($inboxId, $replyMessage)) {
            header('Location: /student-inbox-message/' . $inboxId . '?success=Reply sent successfully');
        } else {
            header('Location: /student-inbox-message/' . $inboxId . '?error=Failed to send reply');
        }
        exit();
    }
    
    public function showComposeForm() {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        $studentId = $_SESSION['student_id']; // Get current student's ID
        
        // Get tutors for the dropdown
        $tutors = $this->model->getAllTutors();
        $activeTab = 'compose';
        
        // Pre-selected recipient (e.g., from tutor profiles)
        $selectedRecipient = isset($_GET['recipient']) ? $_GET['recipient'] : null;
        
        require_once __DIR__ . '/../../Views/student/StudentComposeMessage.php';
    }
    
    // Send a message to tutors and/or admin
    public function sendMessage() {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /student-compose-message');
            exit();
        }
        
        // Validate required fields
        if (!isset($_POST['subject']) || empty($_POST['subject']) ||
            !isset($_POST['message']) || empty($_POST['message'])) {
            header('Location: /student-compose-message?error=Subject and message are required');
            exit();
        }
        
        // Get form data
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $messageType = $_POST['message_type'];
        $studentId = $_SESSION['student_id'];
        
        // Process based on message type
        if ($messageType === 'tutor') {
            // Send to tutors
            if (!isset($_POST['tutors']) || empty($_POST['tutors'])) {
                header('Location: /student-compose-message?error=Please select at least one tutor');
                exit();
            }
            
            $tutorIds = $_POST['tutors'];
            $result = $this->model->sendMessageToTutor($studentId, $tutorIds, $subject, $message);
            
            if ($result) {
                header('Location: /student-compose-message?success=Message sent to selected tutors');
            } else {
                header('Location: /student-compose-message?error=Failed to send message to tutors');
            }
        } elseif ($messageType === 'admin') {
            // Send to admin
            $result = $this->model->sendMessageToAdmin($studentId, $subject, $message);
            
            if ($result) {
                header('Location: /student-compose-message?success=Message sent to admin');
            } else {
                header('Location: /student-compose-message?error=Failed to send message to admin');
            }
        }
        
        exit();
    }

    // Show outbox page with list of sent messages
    public function showOutbox() {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        $activeTab = 'outbox';
        $studentId = $_SESSION['student_id'];
        
        // Handle search form submission
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        // Get sent messages based on filters
        $messages = $this->model->getAllSentMessages($studentId, $page, null, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalSentMessages($studentId, $filter, $searchTerm);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/student/StudentOutbox.php';
    }

    // Show a specific sent message
    public function showSentMessage($messageId, $recipientType) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $studentId = $_SESSION['student_id'];
        
        // Get the active message
        $activeMessage = $this->model->getSentMessage($messageId, $recipientType);
        
        if (!$activeMessage) {
            header('Location: /student-outbox');
            exit();
        }
        
        // Get replies from tutors or admin
        $recipientReplies = [];
        if ($recipientType === 'tutor') {
            $recipientReplies = $this->model->getTutorReplies($messageId);
        } else if ($recipientType === 'admin') {
            $recipientReplies = $this->model->getAdminReplies($messageId);
        }
        
        // Get all sent messages for the sidebar (with same filters as outbox page)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllSentMessages($studentId, $page, null, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalSentMessages($studentId, $filter, $searchTerm);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/student/StudentOutbox.php';
    }
}