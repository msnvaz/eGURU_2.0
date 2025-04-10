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
        
        // Handle search form submission
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            $searchTerm = $_POST['search_term'];
        }
        
        // Get messages based on filters
        $messages = $this->model->getAllMessages($page, $status, $filter, $searchTerm);
        
        // Get total messages for pagination
        $totalMessages = $this->model->getTotalMessages($status, $filter, $searchTerm);
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
}