<?php
namespace App\Models\student;

use App\Config\Database;
use PDO;
use PDOException;

class StudentInboxModel {
    private $conn;

    public function __construct() {
        // Initialize the Database class and get the connection
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }
    
    // Get all messages with pagination and filtering
    public function getAllMessages($studentId, $page = 1, $status = null, $filter = null, $searchTerm = null) {
        $perPage = 10; // Number of messages per page
        $offset = ($page - 1) * $perPage;
        
        // Start with a base query that joins necessary tables
        $query = "SELECT * FROM student_inbox si ";
        
        // Add joins for tutor and admin tables (only when needed for searching)
        $query .= " LEFT JOIN tutor t ON (si.sender_type = 'tutor' AND si.sender_id = t.tutor_id)";
        $query .= " LEFT JOIN admin a ON (si.sender_type = 'admin' AND si.sender_id = a.admin_id)";
        
        $query .= " WHERE si.student_id = :studentId";
        $params = [':studentId' => $studentId];
       
        // Add status filter (archived or not)
        if ($status === 'archived') {
            $query .= " AND si.status = 'archived'";
        } else {
            $query .= " AND si.status != 'archived'";
        }
        
        // Additional filters
        if ($filter === 'unread') {
            $query .= " AND si.status = 'unread'";
        } elseif ($filter === 'read') {
            $query .= " AND si.status = 'read'";
        } elseif ($filter === 'tutor') {
            $query .= " AND si.sender_type = 'tutor'";
        } elseif ($filter === 'admin') {
            $query .= " AND si.sender_type = 'admin'";
        }
        
        // Enhanced search functionality
        if (!empty($searchTerm)) {
            $query .= " AND (si.subject LIKE :searchTerm 
                        OR si.message LIKE :searchTerm
                        OR CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) LIKE :searchTerm
                        OR a.username LIKE :searchTerm
                        OR CAST(t.tutor_id AS CHAR) LIKE :searchTerm
                        OR CAST(a.admin_id AS CHAR) LIKE :searchTerm)";
            $params[':searchTerm'] = "%$searchTerm%";
        }
        
        // Order by newest first
        $query .= " ORDER BY si.sent_at DESC";
        
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
    public function getTotalMessages($studentId, $status = null, $filter = null, $searchTerm = null) {
        $query = "SELECT COUNT(*) FROM student_inbox si";
        
        // Join tables if needed for searching
        if (!empty($searchTerm)) {
            $query .= " LEFT JOIN tutor t ON (si.sender_type = 'tutor' AND si.sender_id = t.tutor_id)";
            $query .= " LEFT JOIN admin a ON (si.sender_type = 'admin' AND si.sender_id = a.admin_id)";
        }
        
        $query .= " WHERE si.student_id = :studentId";
        $params = [':studentId' => $studentId];
        
        // Add status filter (archived or not)
        if ($status === 'archived') {
            $query .= " AND si.status = 'archived'";
        } else {
            $query .= " AND si.status != 'archived'";
        }
        
        // Additional filters
        if ($filter === 'unread') {
            $query .= " AND si.status = 'unread'";
        } elseif ($filter === 'read') {
            $query .= " AND si.status = 'read'";
        } elseif ($filter === 'tutor') {
            $query .= " AND si.sender_type = 'tutor'";
        } elseif ($filter === 'admin') {
            $query .= " AND si.sender_type = 'admin'";
        }
        
        // Search term
        if (!empty($searchTerm)) {
            $query .= " AND (si.subject LIKE :searchTerm 
                      OR si.message LIKE :searchTerm
                      OR CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) LIKE :searchTerm
                      OR a.username LIKE :searchTerm)";
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
    public function getMessage($inboxId, $studentId) {
        $query = "
            SELECT si.*, t.tutor_first_name, t.tutor_last_name
            FROM student_inbox si
            LEFT JOIN tutor t ON si.sender_type = 'tutor' AND si.sender_id = t.tutor_id
            WHERE si.inbox_id = :inboxId AND si.student_id = :studentId
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Mark a message as read
    public function markAsRead($inboxId, $studentId) {
        $query = "UPDATE student_inbox SET status = 'read' WHERE inbox_id = :inboxId AND student_id = :studentId AND status = 'unread'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    // Archive a message
    public function archiveMessage($inboxId) {
        $query = "UPDATE student_inbox SET status = 'archived' WHERE inbox_id = :inboxId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    // Unarchive a message
    public function unarchiveMessage($inboxId) {
        $query = "UPDATE student_inbox SET status = 'read' WHERE inbox_id = :inboxId AND status = 'archived'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    // Get all replies for a message
    public function getReplies($inboxId, $studentId) {
        $query = "
            SELECT sir.*, t.tutor_first_name, t.tutor_last_name 
            FROM student_inbox_reply sir
            LEFT JOIN tutor t ON sir.sender_type = 'tutor'
            LEFT JOIN student_inbox si ON sir.inbox_id = si.inbox_id
            WHERE sir.inbox_id = :inboxId AND si.student_id = :studentId
            ORDER BY sir.created_at ASC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Add a reply to a message
    public function addReply($inboxId, $replyMessage) {
        $sender_type = "student";
        $query = "INSERT INTO student_inbox_reply (inbox_id, message, sender_type) VALUES (:inboxId, :replyMessage, :sender_type)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->bindValue(':replyMessage', $replyMessage, PDO::PARAM_STR);
        $stmt->bindValue(':sender_type', $sender_type, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    // Get all tutors for compose message form
    public function getAllTutors() {
        $query = "SELECT tutor_id, tutor_first_name, tutor_last_name FROM tutor ORDER BY tutor_first_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get unread message count
    public function getUnreadMessageCount($studentId) {
        $query = "SELECT COUNT(*) FROM student_inbox WHERE status = 'unread' AND student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    // Send a message to a tutor
    public function sendMessageToTutor($studentId, $tutorIds, $subject, $message) {
        $query = "INSERT INTO tutor_inbox (tutor_id, sender_type, sender_id, subject, message) 
                  VALUES (:tutorId, 'student', :studentId, :subject, :message)";
        $stmt = $this->conn->prepare($query);
    
        foreach ($tutorIds as $tutorId) {
            $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
            $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
            $stmt->bindValue(':message', $message, PDO::PARAM_STR);
    
            // Execute the query for each tutor ID
            if (!$stmt->execute()) {
                return false; // Return false if any insertion fails
            }
        }
    
        return true; // Return true if all insertions succeed
    }
    
    // Send a message to admin
    public function sendMessageToAdmin($studentId, $subject, $message) {
        $query = "INSERT INTO admin_inbox (sender_type, sender_id, subject, message) 
                 VALUES ('student', :studentId, :subject, :message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    // Get all sent messages
    public function getAllSentMessages($studentId, $page = 1, $status = null, $filter = null, $searchTerm = null) {
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
    
        $query = "";
        $params = [':studentId' => $studentId];
    
        if ($filter === 'tutor') {
            $query = "SELECT 
                        'tutor' as recipient_type,
                        ti.inbox_id as message_id,
                        ti.tutor_id as recipient_id,
                        ti.subject,
                        ti.message,
                        ti.sent_at,
                        ti.status,
                        CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as recipient_name
                    FROM tutor_inbox ti
                    JOIN tutor t ON ti.tutor_id = t.tutor_id
                    WHERE ti.sender_type = 'student' AND ti.sender_id = :studentId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ti.subject LIKE :searchTerm 
                          OR ti.message LIKE :searchTerm
                          OR CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) LIKE :searchTerm
                          OR CAST(t.tutor_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
        } elseif ($filter === 'admin') {
            $query = "SELECT 
                        'admin' as recipient_type,
                        ai.inbox_id as message_id,
                        1 as recipient_id,
                        ai.subject,
                        ai.message,
                        ai.sent_at,
                        ai.status,
                        'admin' as recipient_name
                    FROM admin_inbox ai
                    WHERE ai.sender_type = 'student' AND ai.sender_id = :studentId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ai.subject LIKE :searchTerm 
                          OR ai.message LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
        } else {
            // Combined query
            $query = "(
                        SELECT 
                            'tutor' as recipient_type,
                            ti.inbox_id as message_id,
                            ti.tutor_id as recipient_id,
                            ti.subject,
                            ti.message,
                            ti.sent_at,
                            ti.status,
                            CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as recipient_name
                        FROM tutor_inbox ti
                        JOIN tutor t ON ti.tutor_id = t.tutor_id
                        WHERE ti.sender_type = 'student' AND ti.sender_id = :studentId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ti.subject LIKE :searchTerm 
                          OR ti.message LIKE :searchTerm
                          OR CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) LIKE :searchTerm
                          OR CAST(t.tutor_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
            $query .= ") UNION ALL (
                        SELECT 
                            'admin' as recipient_type,
                            ai.inbox_id as message_id,
                            1 as recipient_id,
                            ai.subject,
                            ai.message,
                            ai.sent_at,
                            ai.status,
                            'admin' as recipient_name
                        FROM admin_inbox ai
                        WHERE ai.sender_type = 'student' AND ai.sender_id = :studentId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ai.subject LIKE :searchTerm2 
                          OR ai.message LIKE :searchTerm2)";
                $params[':searchTerm2'] = "%$searchTerm%";
            }
    
            $query .= ")";
        }
    
        $query .= " ORDER BY sent_at DESC LIMIT :limit OFFSET :offset";
        $params[':limit'] = $perPage;
        $params[':offset'] = $offset;
    
        $stmt = $this->conn->prepare($query);
    
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
    
    // Get total sent messages count
    public function getTotalSentMessages($studentId, $filter = null, $searchTerm = null) {
        $countQuery = "SELECT COUNT(*) FROM (";
        $params = [':studentId' => $studentId];
        
        if ($filter === 'tutor') {
            $query = "SELECT ti.inbox_id
                      FROM tutor_inbox ti
                      JOIN tutor t ON ti.tutor_id = t.tutor_id
                      WHERE ti.sender_type = 'student' AND ti.sender_id = :studentId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ti.subject LIKE :searchTerm 
                          OR ti.message LIKE :searchTerm
                          OR CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) LIKE :searchTerm
                          OR CAST(t.tutor_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
        } elseif ($filter === 'admin') {
            $query = "SELECT ai.inbox_id
                      FROM admin_inbox ai
                      WHERE ai.sender_type = 'student' AND ai.sender_id = :studentId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ai.subject LIKE :searchTerm 
                          OR ai.message LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
        } else {
            $query = "SELECT ti.inbox_id
                      FROM tutor_inbox ti
                      JOIN tutor t ON ti.tutor_id = t.tutor_id
                      WHERE ti.sender_type = 'student' AND ti.sender_id = :studentId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ti.subject LIKE :searchTerm 
                          OR ti.message LIKE :searchTerm
                          OR CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) LIKE :searchTerm
                          OR CAST(t.tutor_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
            $query .= " UNION ALL 
                       SELECT ai.inbox_id
                       FROM admin_inbox ai
                       WHERE ai.sender_type = 'student' AND ai.sender_id = :studentId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ai.subject LIKE :searchTerm2 
                          OR ai.message LIKE :searchTerm2)";
                $params[':searchTerm2'] = "%$searchTerm%";
            }
        }
    
        $countQuery .= $query . ") as combined_messages";
    
        $stmt = $this->conn->prepare($countQuery);
    
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    // Get a specific sent message
    public function getSentMessage($messageId, $recipientType) {
        if ($recipientType === 'tutor') {
            $query = "SELECT 
                        'tutor' as recipient_type,
                        ti.inbox_id as message_id,  
                        ti.tutor_id as recipient_id,
                        ti.subject,
                        ti.message,
                        ti.sent_at,
                        ti.status,
                        ti.sender_id as student_id,
                        CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as recipient_name
                    FROM tutor_inbox ti
                    JOIN tutor t ON ti.tutor_id = t.tutor_id
                    WHERE ti.inbox_id = :messageId AND ti.sender_type = 'student'";  

        } else {
            $query = "SELECT 
                        'admin' as recipient_type,
                        ai.inbox_id as message_id,  
                        1 as recipient_id,
                        ai.subject,
                        ai.message,
                        ai.sent_at,
                        ai.status,
                        ai.sender_id as student_id,
                        'admin' as recipient_name
                    FROM admin_inbox ai
                    WHERE ai.inbox_id = :messageId AND ai.sender_type = 'student'";  
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':messageId', $messageId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Get student replies to tutor messages
    public function getTutorReplies($inboxId) {
        $query = "SELECT tir.*, t.tutor_first_name, t.tutor_last_name 
                FROM tutor_inbox_reply tir
                JOIN tutor_inbox ti ON tir.inbox_id = ti.inbox_id
                JOIN tutor t ON ti.tutor_id = t.tutor_id
                WHERE ti.inbox_id = :inboxId AND ti.sender_type = 'student'
                ORDER BY tir.created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get admin replies to tutor messages
    public function getAdminReplies($inboxId) {
        $query = "SELECT air.*, air.reply_message as message, air.replied_at as created_at, a.username
                FROM admin_inbox_reply air
                JOIN admin_inbox ai ON air.inbox_id = ai.inbox_id
                JOIN admin a ON air.admin_username = a.username
                WHERE ai.inbox_id = :inboxId AND ai.sender_type = 'student'
                ORDER BY air.replied_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


