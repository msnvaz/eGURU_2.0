<?php
namespace App\Controllers\tutor;
use App\Models\tutor\TutorInboxModel;

class TutorInboxController {
    private $model;

    public function __construct() {
        $this->model = new TutorInboxModel();
    }

    
    public function showInbox() {

        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
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
        
        
        $tutorId = $_SESSION['tutor_id']; 
        $messages = $this->model->getAllMessages($tutorId, $page, $status, $filter, $searchTerm);
        
        
        $totalMessages = $this->model->getTotalMessages($tutorId, $status, $filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount($tutorId);
        $perPage = 10;
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/tutor/TutorInbox.php';
    }
    
    
    public function showMessage($inboxId) {

        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
        $tutorId = $_SESSION['tutor_id']; 
        
        // Get the active message
        $activeMessage = $this->model->getMessage($inboxId, $tutorId);
        $unreadCount = $this->model->getUnreadMessageCount($tutorId);
        
        if (!$activeMessage) {
            header('Location: /tutor-inbox');
            exit();
        }
        
        
        if ($activeMessage['status'] === 'unread') {
            $this->model->markAsRead($inboxId, $tutorId);
            
            $activeMessage = $this->model->getMessage($inboxId, $tutorId);
        }
        
        
        $replies = $this->model->getReplies($inboxId, $tutorId);
        
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllMessages($tutorId, $page, $status, $filter, $searchTerm);
        
        
        $totalMessages = $this->model->getTotalMessages($tutorId, $status, $filter, $searchTerm);
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/tutor/TutorInbox.php';
    }
    
    
    public function archiveMessage($inboxId) {
        $this->model->archiveMessage($inboxId);
        header('Location: /tutor-inbox-message/' . $inboxId);
        exit();
    }
    
    
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
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }

        $tutorId = $_SESSION['tutor_id']; 
        
        
        $students = $this->model->getAllStudents();
        $admins =$this->model->getAllAdmins();
        $activeTab = 'compose';
        $unreadCount = $this->model->getUnreadMessageCount($tutorId);
        
        
        $selectedRecipient = isset($_GET['recipient']) ? $_GET['recipient'] : null;
        
        require_once __DIR__ . '/../../Views/tutor/TutorComposeMessage.php';
    }
    
    
    public function sendMessage() {

        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /tutor-compose-message');
            exit();
        }
        
        
        if (!isset($_POST['subject']) || empty($_POST['subject']) ||
            !isset($_POST['message']) || empty($_POST['message'])) {
            header('Location: /tutor-compose-message?error=Subject and message are required');
            exit();
        }
        
        
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $messageType = $_POST['message_type'];
        $tutorId = $_SESSION['tutor_id'];
        
        
        if ($messageType === 'student') {
            
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
            
            $result = $this->model->sendMessageToAdmin($tutorId, $subject, $message);
            
            if ($result) {
                header('Location: /tutor-compose-message?success=Message sent to admin');
            } else {
                header('Location: /tutor-compose-message?error=Failed to send message to admin');
            }
        }
        
        exit();
    }

    
    public function showOutbox() {
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        $activeTab = 'outbox';
        $tutorId = $_SESSION['tutor_id'];
        
        
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        

        $messages = $this->model->getAllSentMessages($tutorId, $page, null, $filter, $searchTerm);
        
        
        $unreadCount = $this->model->getUnreadMessageCount($tutorId);
        $totalMessages = $this->model->getTotalSentMessages($tutorId, $filter, $searchTerm);
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/tutor/TutorOutbox.php';
    }

    
    public function showSentMessage($messageId, $recipientType) {

        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
        $tutorId = $_SESSION['tutor_id'];
        
        
        $activeMessage = $this->model->getSentMessage($messageId, $recipientType);
        $unreadCount = $this->model->getUnreadMessageCount($tutorId);
        
        if (!$activeMessage) {
            header('Location: /tutor-outbox');
            exit();
        }
        
        
        $recipientReplies = [];
        if ($recipientType === 'student') {
            $recipientReplies = $this->model->getStudentReplies($messageId);
        } else if ($recipientType === 'admin') {
            $recipientReplies = $this->model->getAdminReplies($messageId);
        }
        
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllSentMessages($tutorId, $page, null, $filter, $searchTerm);
        
        
        $totalMessages = $this->model->getTotalSentMessages($tutorId, $filter, $searchTerm);
        $perPage = 10;
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/tutor/TutorOutbox.php';
    }

    
}