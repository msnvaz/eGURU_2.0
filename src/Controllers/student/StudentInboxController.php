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

    
    public function showInbox() {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        
        
        if ($status === 'archived') {
            $activeTab = 'archived';
        } else {
            $activeTab = 'inbox';
        }
        
        
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        
        $studentId = $_SESSION['student_id']; 
        $messages = $this->model->getAllMessages($studentId, $page, $status, $filter, $searchTerm);
        
        
        $totalMessages = $this->model->getTotalMessages($studentId, $status, $filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount($studentId);
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/student/StudentInbox.php';
    }
    
    
    public function showMessage($inboxId) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $studentId = $_SESSION['student_id']; 
        
        
        
        $activeMessage = $this->model->getMessage($inboxId, $studentId);
        
        if (!$activeMessage) {
            header('Location: /student-inbox');
            exit();
        }
        
        
        if ($activeMessage['status'] === 'unread') {
            $this->model->markAsRead($inboxId, $studentId);
            
            $activeMessage = $this->model->getMessage($inboxId, $studentId);
        }
        
        
        $replies = $this->model->getReplies($inboxId, $studentId);
        
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllMessages($studentId, $page, $status, $filter, $searchTerm);
        
        
        $totalMessages = $this->model->getTotalMessages($studentId, $status, $filter, $searchTerm);
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/student/StudentInbox.php';
    }
    
    
    public function archiveMessage($inboxId) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $studentId = $_SESSION['student_id'];
        
        
        $message = $this->model->getMessage($inboxId, $studentId);
        if (!$message) {
            header('Location: /student-inbox');
            exit();
        }
        
        $this->model->archiveMessage($inboxId);
        header('Location: /student-inbox-message/' . $inboxId);
        exit();
    }
    
    
    public function unarchiveMessage($inboxId) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $studentId = $_SESSION['student_id'];
        
        
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

        $studentId = $_SESSION['student_id']; 
        
        
        $tutors = $this->model->getAllTutors();
        $activeTab = 'compose';
        
 
        $selectedRecipient = isset($_GET['recipient']) ? $_GET['recipient'] : null;
        
        require_once __DIR__ . '/../../Views/student/StudentComposeMessage.php';
    }
    
    
    public function sendMessage() {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /student-compose-message');
            exit();
        }
        
        
        if (!isset($_POST['subject']) || empty($_POST['subject']) ||
            !isset($_POST['message']) || empty($_POST['message'])) {
            header('Location: /student-compose-message?error=Subject and message are required');
            exit();
        }
        
        
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $messageType = $_POST['message_type'];
        $studentId = $_SESSION['student_id'];
        
        
        if ($messageType === 'tutor') {
            
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
            
            $result = $this->model->sendMessageToAdmin($studentId, $subject, $message);
            
            if ($result) {
                header('Location: /student-compose-message?success=Message sent to admin');
            } else {
                header('Location: /student-compose-message?error=Failed to send message to admin');
            }
        }
        
        exit();
    }

    
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
        
       
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        
        $messages = $this->model->getAllSentMessages($studentId, $page, null, $filter, $searchTerm);
        
        
        $totalMessages = $this->model->getTotalSentMessages($studentId, $filter, $searchTerm);
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/student/StudentOutbox.php';
    }

    
    public function showSentMessage($messageId, $recipientType) {
        

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }
        
        $studentId = $_SESSION['student_id'];
        
        
        $activeMessage = $this->model->getSentMessage($messageId, $recipientType);
        
        if (!$activeMessage) {
            header('Location: /student-outbox');
            exit();
        }
        
       
        $recipientReplies = [];
        if ($recipientType === 'tutor') {
            $recipientReplies = $this->model->getTutorReplies($messageId);
        } else if ($recipientType === 'admin') {
            $recipientReplies = $this->model->getAdminReplies($messageId);
        }
        
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllSentMessages($studentId, $page, null, $filter, $searchTerm);
        
        
        $totalMessages = $this->model->getTotalSentMessages($studentId, $filter, $searchTerm);
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/student/StudentOutbox.php';
    }
}