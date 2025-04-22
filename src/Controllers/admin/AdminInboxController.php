<?php
namespace App\Controllers\admin;
use App\Models\admin\adminInboxModel;

class adminInboxController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); // Redirect to login page if not logged in
            exit();
        } 
        $this->model = new adminInboxModel();
    }

    // Show inbox page with list of messages
    public function showInbox() {
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
        $messages = $this->model->getAllMessages($page, $status, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalMessages($status, $filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount();
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminInbox.php';
    }
    
    // Show a specific message
    public function showMessage($inboxId) {
        // Get the active message
        $activeMessage = $this->model->getMessage($inboxId);
        
        if (!$activeMessage) {
            header('Location: /admin-inbox');
            exit();
        }
        
        // Mark message as read if it was unread
        if ($activeMessage['status'] === 'unread') {
            $this->model->markAsRead($inboxId);
            // Refresh the message data to get updated status
            $activeMessage = $this->model->getMessage($inboxId);
        }
        
        // Get all replies for this message
        $replies = $this->model->getReplies($inboxId);
        
        // Get all messages for the sidebar (with same filters as inbox page)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $messages = $this->model->getAllMessages($page, $status, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalMessages($status, $filter, $searchTerm);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminInbox.php';
    }
    
    // Archive a message
    public function archiveMessage($inboxId) {
        $this->model->archiveMessage($inboxId);
        header('Location: /admin-inbox-message/' . $inboxId);
        exit();
    }
    
    // Unarchive a message
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
        
        // Check if admin_username is set in session
        if (!isset($_SESSION['admin_username']) || empty($_SESSION['admin_username'])) {
            // If we have admin_id but not username, try to fetch the username from the database
            if (isset($_SESSION['admin_id'])) {
                $adminUsername = $this->model->getAdminUsername($_SESSION['admin_id']);
                
                // If we still don't have a valid username, we can't proceed
                if (!$adminUsername) {
                    header('Location: /admin-inbox-message/' . $inboxId . '?error=Cannot identify admin user. Please log out and log in again.');
                    exit();
                }
            } else {
                // No admin id or username available
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
        // Get students and tutors for the drop-downs
        $students = $this->model->getAllStudents();
        $tutors = $this->model->getAllTutors();
        $activeTab = 'compose';
        
        // Message type (student, tutor, or both)
        $messageType = isset($_GET['type']) ? $_GET['type'] : 'student';
        
        // Pre-selected recipient (from reports)
        $selectedRecipient = isset($_GET['recipient']) ? $_GET['recipient'] : null;
        
        require_once __DIR__ . '/../../Views/admin/AdminComposeMessage.php';
    }
    
    // NEW: Send a message to students and/or tutors
    public function sendMessage() {
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin-compose-message');
            exit();
        }
        
        // Validate required fields
        if (!isset($_POST['subject']) || empty($_POST['subject']) ||
            !isset($_POST['message']) || empty($_POST['message'])) {
            header('Location: /admin-compose-message?error=Subject and message are required');
            exit();
        }
        
        // Get form data
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $messageType = $_POST['message_type'];
        
        // Get admin ID
        $adminId = $_SESSION['admin_id'] ?? 1; // Default to 1 if not set
        
        // Process based on message type
        if ($messageType === 'student') {
            // Send to students
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
            // Send to tutors
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
            // Send to both students and tutors
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

    // Show outbox page with list of sent messages
    public function showOutbox() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        $activeTab = 'outbox';
        
        // Handle search form submission
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        // Get sent messages based on filters
        $messages = $this->model->getAllSentMessages($page, null, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalSentMessages($filter, $searchTerm);
        $perPage = 10; // Should match the value in the model
        $totalPages = ceil($totalMessages / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminOutbox.php';
    }

    // Show a specific sent message
public function showSentMessage($messageId, $recipientType) {
    // Get the active message
    $activeMessage = $this->model->getSentMessage($messageId, $recipientType);
    
    if (!$activeMessage) {
        header('Location: /admin-outbox');
        exit();
    }
    
    // Get replies from students or tutors
    $recipientReplies = [];
    if ($recipientType === 'student') {
        $recipientReplies = $this->model->getStudentReplies($messageId);
    } else if ($recipientType === 'tutor') {
        $recipientReplies = $this->model->getTutorReplies($messageId);
    }
    
    // Get all sent messages for the sidebar (with same filters as outbox page)
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
    $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
    
    $messages = $this->model->getAllSentMessages($page, null, $filter, $searchTerm);
    
    // Get total messages for pagination
    $totalMessages = $this->model->getTotalSentMessages($filter, $searchTerm);
    $perPage = 10; // Should match the value in the model
    $totalPages = ceil($totalMessages / $perPage);
    $currentPage = $page;
    
    require_once __DIR__ . '/../../Views/admin/AdminOutbox.php';
}

    // Show tutor reports page
    public function showTutorReports() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = null;
        $activeTab = 'reports';
        
        // Handle search form submission
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        // Get reports based on filters
        $reports = $this->model->getAllTutorReports($page, $filter, $searchTerm);
        
        // Get total reports for pagination
        $totalReports = $this->model->getTotalTutorReports($filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount();
        $perPage = 10;
        $totalPages = ceil($totalReports / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminTutorReports.php';
    }

    // Show a specific tutor report
    public function showTutorReport($reportId) {
        // Get the active report
        $activeReport = $this->model->getTutorReport($reportId);
        
        if (!$activeReport) {
            header('Location: /admin-tutor-reports');
            exit();
        }
        
        // Get all reports for the sidebar (with same filters as reports page)
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
        $searchTerm = isset($_GET['search_term']) ? $_GET['search_term'] : null;
        
        $reports = $this->model->getAllTutorReports($page, $filter, $searchTerm);
        
        // Get total reports for pagination
        $totalReports = $this->model->getTotalTutorReports($filter, $searchTerm);
        $unreadCount = $this->model->getUnreadMessageCount();
        $perPage = 10;
        $totalPages = ceil($totalReports / $perPage);
        $currentPage = $page;
        
        require_once __DIR__ . '/../../Views/admin/AdminTutorReports.php';
    }
}