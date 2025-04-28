<?php
namespace App\Controllers\admin;
use App\Models\admin\adminInboxModel;

class adminInboxController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); 
            exit();
        } 
        $this->model = new adminInboxModel();
    }

    public function showInbox() {
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
        
        $messages = $this->model->getAllMessages($page, $status, $filter, $searchTerm);
        
        $totalMessages = $this->model->getTotalMessages($status, $filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount();
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminInbox.php';
    }
    
    public function showMessage($inboxId) {
        $activeMessage = $this->model->getMessage($inboxId);
        
        if (!$activeMessage) {
            header('Location: /admin-inbox');
            exit();
        }
        
        if ($activeMessage['status'] === 'unread') {
            $this->model->markAsRead($inboxId);
            $activeMessage = $this->model->getMessage($inboxId);
        }
        
        $replies = $this->model->getReplies($inboxId);
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllMessages($page, $status, $filter, $searchTerm);
        
        $totalMessages = $this->model->getTotalMessages($status, $filter, $searchTerm);
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminInbox.php';
    }
    
    public function archiveMessage($inboxId) {
        $this->model->archiveMessage($inboxId);
        header('Location: /admin-inbox-message/' . $inboxId);
        exit();
    }
    
    public function unarchiveMessage($inboxId) {
        $this->model->unarchiveMessage($inboxId);
        header('Location: /admin-inbox-message/' . $inboxId);
        exit();
    }
    
    public function replyToMessage($inboxId) {
        if (!isset($_POST['reply_message']) || empty($_POST['reply_message'])) {
            header('Location: /admin-inbox-message/' . $inboxId . '?error=Reply message is required');
            exit();
        }
        
        $replyMessage = $_POST['reply_message'];
        
        if (!isset($_SESSION['admin_username']) || empty($_SESSION['admin_username'])) {
            if (isset($_SESSION['admin_id'])) {
                $adminUsername = $this->model->getAdminUsername($_SESSION['admin_id']);
                
                if (!$adminUsername) {
                    header('Location: /admin-inbox-message/' . $inboxId . '?error=Cannot identify admin user. Please log out and log in again.');
                    exit();
                }
            } else {
                header('Location: /admin-login?redirect=/admin-inbox-message/' . $inboxId);
                exit();
            }
        } else {
            $adminUsername = $_SESSION['admin_username'];
        }
        
        if ($this->model->addReply($inboxId, $adminUsername, $replyMessage)) {
            header('Location: /admin-inbox-message/' . $inboxId . '?success=Reply sent successfully');
        } else {
            header('Location: /admin-inbox-message/' . $inboxId . '?error=Failed to send reply');
        }
        exit();
    }
    
    public function showComposeForm() {
        $students = $this->model->getAllStudents();
        $tutors = $this->model->getAllTutors();
        $activeTab = 'compose';
        
        $messageType = isset($_GET['type']) ? $_GET['type'] : 'student';
        
        $selectedRecipient = isset($_GET['recipient']) ? $_GET['recipient'] : null;
        
        require_once __DIR__ . '/../../Views/admin/AdminComposeMessage.php';
    }
    
    public function sendMessage() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin-compose-message');
            exit();
        }
        
        if (!isset($_POST['subject']) || empty($_POST['subject']) ||
            !isset($_POST['message']) || empty($_POST['message'])) {
            header('Location: /admin-compose-message?error=Subject and message are required');
            exit();
        }
        
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $messageType = $_POST['message_type'];
        
        $adminId = $_SESSION['admin_id'] ?? 1;  
        
        if ($messageType === 'student') {
            if (!isset($_POST['students']) || empty($_POST['students'])) {
                header('Location: /admin-compose-message?type=student&error=Please select at least one student');
                exit();
            }
            
            $studentIds = $_POST['students'];
            $result = $this->model->sendMessageToMultipleStudents($studentIds, $adminId, $subject, $message);
            
            if ($result) {
                header('Location: /admin-compose-message?type=student&success=Message sent to selected students');
            } else {
                header('Location: /admin-compose-message?type=student&error=Failed to send message to students');
            }
        } elseif ($messageType === 'tutor') {
            if (!isset($_POST['tutors']) || empty($_POST['tutors'])) {
                header('Location: /admin-compose-message?type=tutor&error=Please select at least one tutor');
                exit();
            }
            
            $tutorIds = $_POST['tutors'];
            $result = $this->model->sendMessageToMultipleTutors($tutorIds, $adminId, $subject, $message);
            
            if ($result) {
                header('Location: /admin-compose-message?type=tutor&success=Message sent to selected tutors');
            } else {
                header('Location: /admin-compose-message?type=tutor&error=Failed to send message to tutors');
            }
        } elseif ($messageType === 'both') {
            $studentIds = $_POST['students'] ?? [];
            $tutorIds = $_POST['tutors'] ?? [];
            
            if (empty($studentIds) && empty($tutorIds)) {
                header('Location: /admin-compose-message?type=both&error=Please select at least one recipient');
                exit();
            }
            
            $studentResult = true;
            $tutorResult = true;
            
            if (!empty($studentIds)) {
                $studentResult = $this->model->sendMessageToMultipleStudents($studentIds, $adminId, $subject, $message);
            }
            
            if (!empty($tutorIds)) {
                $tutorResult = $this->model->sendMessageToMultipleTutors($tutorIds, $adminId, $subject, $message);
            }
            
            if ($studentResult && $tutorResult) {
                header('Location: /admin-compose-message?type=both&success=Message sent to selected recipients');
            } else {
                header('Location: /admin-compose-message?type=both&error=Failed to send message to some recipients');
            }
        }
        
        exit();
    }

    public function showOutbox() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        $activeTab = 'outbox';
        
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        $messages = $this->model->getAllSentMessages($page, null, $filter, $searchTerm);
        
        $totalMessages = $this->model->getTotalSentMessages($filter, $searchTerm);
        $perPage = 10; 
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminOutbox.php';
    }

public function showSentMessage($messageId, $recipientType) {
    $activeMessage = $this->model->getSentMessage($messageId, $recipientType);
    
    if (!$activeMessage) {
        header('Location: /admin-outbox');
        exit();
    }
    
    $recipientReplies = [];
    if ($recipientType === 'student') {
        $recipientReplies = $this->model->getStudentReplies($messageId);
    } else if ($recipientType === 'tutor') {
        $recipientReplies = $this->model->getTutorReplies($messageId);
    }
    
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
    $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
    
    $messages = $this->model->getAllSentMessages($page, null, $filter, $searchTerm);
    
    $totalMessages = $this->model->getTotalSentMessages($filter, $searchTerm);
    $perPage = 10;  
    $totalPages = ceil($totalMessages / $perPage);
    $currentPage = $page;
    
    require_once __DIR__ . '/../../Views/admin/AdminOutbox.php';
}

    public function showTutorReports() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        $activeTab = 'reports';
        
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        $reports = $this->model->getAllTutorReports($page, $filter, $searchTerm);
        
        $totalReports = $this->model->getTotalTutorReports($filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount();
        $perPage = 10;
        $totalPages = ceil($totalReports / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminTutorReports.php';
    }

    public function showTutorReport($reportId) {
        $activeReport = $this->model->getTutorReport($reportId);
        
        if (!$activeReport) {
            header('Location: /admin-tutor-reports');
            exit();
        }
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $reports = $this->model->getAllTutorReports($page, $filter, $searchTerm);
        
        $totalReports = $this->model->getTotalTutorReports($filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount();
        $perPage = 10;
        $totalPages = ceil($totalReports / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminTutorReports.php';
    }
}