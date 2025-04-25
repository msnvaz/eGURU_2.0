<?php
namespace App\Controllers\tutor;
use App\Models\tutor\TutorInboxModel;

class TutorInboxController {
    private $model;

    public function __construct() {
        $this->model = new TutorInboxModel();
    }

    // Show inbox page with list of messages
    public function showInbox() {

        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
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
        $tutorId = $_SESSION['tutor_id']; // Get current tutor's ID
        $messages = $this->model->getAllMessages($tutorId, $page, $status, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalMessages($tutorId, $status, $filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount($tutorId);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/tutor/TutorInbox.php';
    }
    
    // Show a specific message
    public function showMessage($inboxId) {

        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
        $tutorId = $_SESSION['tutor_id']; // Get current tutor's ID
        
        // Get the active message
        $activeMessage = $this->model->getMessage($inboxId, $tutorId);
        
        if (!$activeMessage) {
            header('Location: /tutor-inbox');
            exit();
        }
        
        // Mark message as read if it was unread
        if ($activeMessage['status'] === 'unread') {
            $this->model->markAsRead($inboxId, $tutorId);
            // Refresh the message data to get updated status
            $activeMessage = $this->model->getMessage($inboxId, $tutorId);
        }
        
        // Get all replies for this message
        $replies = $this->model->getReplies($inboxId, $tutorId);
        
        // Get all messages for the sidebar (with same filters as inbox page)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllMessages($tutorId, $page, $status, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalMessages($tutorId, $status, $filter, $searchTerm);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/tutor/TutorInbox.php';
    }
    
    // Archive a message
    public function archiveMessage($inboxId) {
        $this->model->archiveMessage($inboxId);
        header('Location: /tutor-inbox-message/' . $inboxId);
        exit();
    }
    
    // Unarchive a message
    public function unarchiveMessage($inboxId) {
        $this->model->unarchiveMessage($inboxId);
        header('Location: /tutor-inbox-message/' . $inboxId);
        exit();
    }
    
    public function replyToMessage($inboxId) {
        if (!isset($_POST['reply_message']) || empty($_POST['reply_message'])) {
            header('Location: /tutor-inbox-message/' . $inboxId . '?error=Reply message is required');
            exit();
        }
        
        $replyMessage = $_POST['reply_message'];
        
        if ($this->model->addReply($inboxId, $replyMessage)) {
            header('Location: /tutor-inbox-message/' . $inboxId . '?success=Reply sent successfully');
        } else {
            header('Location: /tutor-inbox-message/' . $inboxId . '?error=Failed to send reply');
        }
        exit();
    }
    
    public function showComposeForm() {
        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }

        $tutorId = $_SESSION['tutor_id']; // Get current tutor's ID
        
        // Get students for the drop-downs (only students assigned to this tutor)
        $students = $this->model->getAllStudents();
        $admins =$this->model->getAllAdmins();
        $activeTab = 'compose';
        
        // Pre-selected recipient (from student profiles)
        $selectedRecipient = isset($_GET['recipient']) ? $_GET['recipient'] : null;
        
        require_once __DIR__ . '/../../Views/tutor/TutorComposeMessage.php';
    }
    
    // Send a message to students and/or admin
    public function sendMessage() {

        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /tutor-compose-message');
            exit();
        }
        
        // Validate required fields
        if (!isset($_POST['subject']) || empty($_POST['subject']) ||
            !isset($_POST['message']) || empty($_POST['message'])) {
            header('Location: /tutor-compose-message?error=Subject and message are required');
            exit();
        }
        
        // Get form data
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $messageType = $_POST['message_type'];
        $tutorId = $_SESSION['tutor_id'];
        
        // Process based on message type
        if ($messageType === 'student') {
            // Send to students
            if (!isset($_POST['students']) || empty($_POST['students'])) {
                header('Location: /tutor-compose-message?error=Please select at least one student');
                exit();
            }
            
            $studentIds = $_POST['students'];
            $result = $this->model->sendMessageToMultipleStudents($tutorId, $studentIds, $subject, $message);
            
            if ($result) {
                header('Location: /tutor-compose-message?success=Message sent to selected students');
            } else {
                header('Location: /tutor-compose-message?error=Failed to send message to students');
            }
        } elseif ($messageType === 'admin') {
            // Send to admin
            $result = $this->model->sendMessageToAdmin($tutorId, $subject, $message);
            
            if ($result) {
                header('Location: /tutor-compose-message?success=Message sent to admin');
            } else {
                header('Location: /tutor-compose-message?error=Failed to send message to admin');
            }
        }
        
        exit();
    }

    // Show outbox page with list of sent messages
    public function showOutbox() {
        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        $activeTab = 'outbox';
        $tutorId = $_SESSION['tutor_id'];
        
        // Handle search form submission
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        // Get sent messages based on filters
        $messages = $this->model->getAllSentMessages($tutorId, $page, null, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalSentMessages($tutorId, $filter, $searchTerm);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/tutor/TutorOutbox.php';
    }

    // Show a specific sent message
    public function showSentMessage($messageId, $recipientType) {

        //session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
        $tutorId = $_SESSION['tutor_id'];
        
        // Get the active message
        $activeMessage = $this->model->getSentMessage($messageId, $recipientType);
        
        if (!$activeMessage) {
            header('Location: /tutor-outbox');
            exit();
        }
        
        // Get replies from students or admin
        $recipientReplies = [];
        if ($recipientType === 'student') {
            $recipientReplies = $this->model->getStudentReplies($messageId);
        } else if ($recipientType === 'admin') {
            $recipientReplies = $this->model->getAdminReplies($messageId);
        }
        
        // Get all sent messages for the sidebar (with same filters as outbox page)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllSentMessages($tutorId, $page, null, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalSentMessages($tutorId, $filter, $searchTerm);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/tutor/TutorOutbox.php';
    }

    
}