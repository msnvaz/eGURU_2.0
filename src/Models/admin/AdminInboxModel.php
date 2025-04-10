<?php
namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class adminInboxModel {
    private $conn;

    public function __construct() {
        // Initialize the Database class and get the connection
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    // Add this method to adminInboxModel.php
    public function getAdminUsername($adminId) {
        $query = "SELECT username FROM admin WHERE admin_id = :adminId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    // Get all messages with pagination and filtering
    public function getAllMessages($page = 1, $status = null, $filter = null, $searchTerm = null) {
        $perPage = 10; // Number of messages per page
        $offset = ($page - 1) * $perPage;
        
        // Start with a base query that joins necessary tables
        $query = "SELECT ai.* FROM admin_inbox ai";
        
        // Add joins for student and tutor tables (only when needed for searching)
        if (!empty($searchTerm)) {
            $query .= " LEFT JOIN student s ON (ai.sender_type = 'student' AND ai.sender_id = s.student_id)";
            $query .= " LEFT JOIN tutor t ON (ai.sender_type = 'tutor' AND ai.sender_id = t.tutor_id)";
        }
        
        $query .= " WHERE 1=1";
        $params = [];
        
        // Add status filter (archived or not)
        if ($status === 'archived') {
            $query .= " AND ai.status = 'archived'";
        } else {
            $query .= " AND ai.status != 'archived'";
        }
        
        // Additional filters
        if ($filter === 'unread') {
            $query .= " AND ai.status = 'unread'";
        } elseif ($filter === 'read') {
            $query .= " AND ai.status = 'read'";
        } elseif ($filter === 'student') {
            $query .= " AND ai.sender_type = 'student'";
        } elseif ($filter === 'tutor') {
            $query .= " AND ai.sender_type = 'tutor'";
        }
        
        // Enhanced search functionality
        if (!empty($searchTerm)) {
            $query .= " AND (ai.subject LIKE :searchTerm 
                        OR ai.message LIKE :searchTerm
                        OR CONCAT(s.student_first_name, ' ', s.student_last_name) LIKE :searchTerm
                        OR CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) LIKE :searchTerm
                        OR CAST(s.student_id AS CHAR) LIKE :searchTerm
                        OR CAST(t.tutor_id AS CHAR) LIKE :searchTerm)";
            $params[':searchTerm'] = "%$searchTerm%";
        }
        
        // Order by newest first
        $query .= " ORDER BY ai.sent_at DESC";
        
        // Add limit and offset for pagination
        $query .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = $perPage;
        $params[':offset'] = $offset;
        
        // Prepare and execute the query
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters
        foreach ($params as $key => $value) {
            if ($key === ':limit' || $key === ':offset') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get total count of messages for pagination
    public function getTotalMessages($status = null, $filter = null, $searchTerm = null) {
        $query = "SELECT COUNT(*) FROM admin_inbox WHERE 1=1";
        $params = [];
        
        // Add status filter (archived or not)
        if ($status === 'archived') {
            $query .= " AND status = 'archived'";
        } else {
            $query .= " AND status != 'archived'";
        }
        
        // Additional filters
        if ($filter === 'unread') {
            $query .= " AND status = 'unread'";
        } elseif ($filter === 'read') {
            $query .= " AND status = 'read'";
        } elseif ($filter === 'student') {
            $query .= " AND sender_type = 'student'";
        } elseif ($filter === 'tutor') {
            $query .= " AND sender_type = 'tutor'";
        }
        
        // Search term
        if (!empty($searchTerm)) {
            $query .= " AND (subject LIKE :searchTerm OR message LIKE :searchTerm)";
            $params[':searchTerm'] = "%$searchTerm%";
        }
        
        // Prepare and execute the query
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    // Get a specific message
    public function getMessage($inboxId) {
        $query = "SELECT * FROM admin_inbox WHERE inbox_id = :inboxId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Mark a message as read
    public function markAsRead($inboxId) {
        $query = "UPDATE admin_inbox SET status = 'read' WHERE inbox_id = :inboxId AND status = 'unread'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    // Archive a message
    public function archiveMessage($inboxId) {
        $query = "UPDATE admin_inbox SET status = 'archived' WHERE inbox_id = :inboxId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    // Unarchive a message
    public function unarchiveMessage($inboxId) {
        $query = "UPDATE admin_inbox SET status = 'read' WHERE inbox_id = :inboxId AND status = 'archived'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    // Get all replies for a message
    public function getReplies($inboxId) {
        $query = "SELECT * FROM admin_inbox_reply WHERE inbox_id = :inboxId ORDER BY replied_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Add a reply to a message
    public function addReply($inboxId, $adminUsername, $replyMessage) {
        // Set a default value if adminUsername is null
        if ($adminUsername === null) {
            $adminUsername = 'Admin';
        }
        
        $query = "INSERT INTO admin_inbox_reply (inbox_id, admin_username, reply_message) VALUES (:inboxId, :adminUsername, :replyMessage)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->bindValue(':adminUsername', $adminUsername, PDO::PARAM_STR);
        $stmt->bindValue(':replyMessage', $replyMessage, PDO::PARAM_STR);
        return $stmt->execute();
    }
}