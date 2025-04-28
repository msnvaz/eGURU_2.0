<?php
namespace App\Models\tutor;

use App\Config\Database;
use PDO;
use PDOException;

class TutorInboxModel {
    private $conn;

    public function __construct() {
        
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }
    
    
    public function getAllMessages($tutorId, $page = 1, $status = null, $filter = null, $searchTerm = null) {
        $perPage = 10; 
        $offset = ($page - 1) * $perPage;
        
        
        $query = "SELECT * FROM tutor_inbox ti ";
        
        
        // Add joins for student and admin tables (only when needed for searching)
        //if (!empty($searchTerm)) {
            $query .= " LEFT JOIN student s ON (ti.sender_type = 'student' AND ti.sender_id = s.student_id)";
            $query .= " LEFT JOIN admin a ON (ti.sender_type = 'admin' AND ti.sender_id = a.admin_id)";
        //}
        
        $query .= " WHERE ti.tutor_id = :tutorId";  
        $params = [];
        $params = [':tutorId' => $tutorId];
       
        
        
        if ($status === 'archived') {
            $query .= " AND ti.status = 'archived'";
        } else {
            $query .= " AND ti.status != 'archived'";
        }
        
       
        if ($filter === 'unread') {
            $query .= " AND ti.status = 'unread'";
        } elseif ($filter === 'read') {
            $query .= " AND ti.status = 'read'";
        } elseif ($filter === 'student') {
            $query .= " AND ti.sender_type = 'student'";
        } elseif ($filter === 'admin') {
            $query .= " AND ti.sender_type = 'admin'";
        }
        
        
        if (!empty($searchTerm)) {
            $query .= " AND (ti.subject LIKE :searchTerm 
                        OR ti.message LIKE :searchTerm
                        OR CONCAT(s.student_first_name, ' ', s.student_last_name) LIKE :searchTerm
                        OR a.username LIKE :searchTerm
                        OR CAST(s.student_id AS CHAR) LIKE :searchTerm
                        OR CAST(a.admin_id AS CHAR) LIKE :searchTerm)";
            $params[':searchTerm'] = "%$searchTerm%";
        }
        
        
        $query .= " ORDER BY ti.sent_at DESC";
        
        
        $query .= " LIMIT :limit OFFSET :offset";
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
    
    
    public function getTotalMessages($tutorId, $status = null, $filter = null, $searchTerm = null) {
        $query = "SELECT COUNT(*) FROM tutor_inbox WHERE tutor_id = :tutorId";
        $params = [];
        $params = [':tutorId' => $tutorId];
        
        
        if ($status === 'archived') {
            $query .= " AND status = 'archived'";
        } else {
            $query .= " AND status != 'archived'";
        }
        
        
        if ($filter === 'unread') {
            $query .= " AND status = 'unread'";
        } elseif ($filter === 'read') {
            $query .= " AND status = 'read'";
        } elseif ($filter === 'student') {
            $query .= " AND sender_type = 'student'";
        } elseif ($filter === 'admin') {
            $query .= " AND sender_type = 'admin'";
        }
        
        
        if (!empty($searchTerm)) {
            $query .= " AND (subject LIKE :searchTerm OR message LIKE :searchTerm)";
            $params[':searchTerm'] = "%$searchTerm%";
        }
        
        
        $stmt = $this->conn->prepare($query);
        
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    
    public function getMessage($inboxId, $tutorId) {
        $query = "
            SELECT ti.*, s.student_first_name, s.student_last_name
            FROM tutor_inbox ti
            LEFT JOIN student s ON ti.sender_type = 'student' AND ti.sender_id = s.student_id
            WHERE ti.inbox_id = :inboxId AND ti.tutor_id = :tutorId
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    


public function markAsRead($inboxId, $tutorId) {
    $query = "UPDATE tutor_inbox SET status = 'read' WHERE inbox_id = :inboxId AND tutor_id = :tutorId AND status = 'unread'";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
    $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
    return $stmt->execute();
}


public function archiveMessage($inboxId) {
    $query = "UPDATE tutor_inbox SET status = 'archived' WHERE inbox_id = :inboxId";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
    return $stmt->execute();
}


public function unarchiveMessage($inboxId) {
    $query = "UPDATE tutor_inbox SET status = 'read' WHERE inbox_id = :inboxId AND status = 'archived'";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
    return $stmt->execute();
}


public function getReplies($inboxId, $tutorId) {
    $query = "
        SELECT tir.*, t.* 
        FROM tutor_inbox_reply tir
        INNER JOIN tutor_inbox ti ON tir.inbox_id = ti.inbox_id
        INNER JOIN tutor t ON ti.tutor_id = t.tutor_id
        WHERE tir.inbox_id = :inboxId AND ti.tutor_id = :tutorId
        ORDER BY tir.created_at ASC
    ";
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
    $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    
    
    public function addReply($inboxId, $replyMessage) {
        $sender_type = "tutor";
        $query = "INSERT INTO tutor_inbox_reply (inbox_id, message, sender_type) VALUES (:inboxId,  :replyMessage, :sender_type)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->bindValue(':replyMessage', $replyMessage, PDO::PARAM_STR);
        $stmt->bindValue(':sender_type', $sender_type, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    
    public function getAllStudents() {
        $query = "SELECT student_id, student_first_name, student_last_name FROM student ORDER BY student_first_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function getAllAdmins() {
        $query = "SELECT admin_id, username FROM admin ORDER BY username ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function sendMessageToStudent($studentId, $tutorId, $subject, $message) {
        $query = "INSERT INTO student_inbox (student_id, sender_type, sender_id, subject, message) 
                 VALUES (:studentId, 'tutor', :tutorId, :subject, :message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    
    public function sendMessageToAdmin( $tutorId, $subject, $message) {
        $query = "INSERT INTO admin_inbox (sender_type, sender_id, subject, message) 
                 VALUES ('tutor', :tutorId, :subject, :message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function sendMessageToMultipleStudents( $tutorId, $studentIds, $subject, $message) {
        try {
            $this->conn->beginTransaction();
    
            $query = "INSERT INTO student_inbox (student_id, sender_type, sender_id, subject, message) 
                      VALUES (:studentId, 'tutor', :tutorId, :subject, :message)";
            $stmt = $this->conn->prepare($query);
    
            foreach ($studentIds as $studentId) {
                $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
                $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
                $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
                $stmt->bindValue(':message', $message, PDO::PARAM_STR);
                
                if (!$stmt->execute()) {
                    error_log("Insert failed: " . implode(", ", $stmt->errorInfo())); // Debug log
                    $this->conn->rollBack();
                    return false;
                }
            }
    
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            error_log("Transaction failed: " . $e->getMessage()); // Debug log
            $this->conn->rollBack();
            return false;
        }
    }
    
    
    
    public function sendMessageToMultipleAdmins($adminIds, $tutorId, $subject, $message) {
        try {
            $this->conn->beginTransaction();
            
            foreach ($adminIds as $adminId) {
                $query = "INSERT INTO admin_inbox (admin_id, sender_type, sender_id, subject, message) 
                         VALUES (:adminId, 'tutor', :tutorId, :subject, :message)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);
                $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
                $stmt->bindValue(':subject', $subject, PDO::PARAM_STR);
                $stmt->bindValue(':message', $message, PDO::PARAM_STR);
                $stmt->execute();
            }
            
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getAllSentMessages($tutorId, $page = 1, $status = null, $filter = null, $searchTerm = null) {
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
    
        $query = "";
        $params = [':tutorId' => $tutorId];
    
        if ($filter === 'student') {
            $query = "SELECT 
                        'student' as recipient_type,
                        si.inbox_id as message_id,
                        si.student_id as recipient_id,
                        si.subject,
                        si.message,
                        si.sent_at,
                        si.status,
                        CONCAT(s.student_first_name, ' ', s.student_last_name) as recipient_name,
                        NULL as tutor_name
                    FROM student_inbox si
                    JOIN student s ON si.student_id = s.student_id
                    WHERE si.sender_type = 'tutor' AND si.sender_id = :tutorId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (si.subject LIKE :searchTerm 
                          OR si.message LIKE :searchTerm
                          OR CONCAT(s.student_first_name, ' ', s.student_last_name) LIKE :searchTerm
                          OR CAST(s.student_id AS CHAR) LIKE :searchTerm)";
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
                        'admin' as recipient_name,
                        NULL as tutor_name
                    FROM admin_inbox ai
                    WHERE ai.sender_type = 'tutor' AND ai.sender_id = :tutorId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ai.subject LIKE :searchTerm 
                          OR ai.message LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
        } else {
            
            $query = "(
                        SELECT 
                            'student' as recipient_type,
                            si.inbox_id as message_id,
                            si.student_id as recipient_id,
                            si.subject,
                            si.message,
                            si.sent_at,
                            si.status,
                            CONCAT(s.student_first_name, ' ', s.student_last_name) as recipient_name,
                            NULL as tutor_name
                        FROM student_inbox si
                        JOIN student s ON si.student_id = s.student_id
                        WHERE si.sender_type = 'tutor' AND si.sender_id = :tutorId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (si.subject LIKE :searchTerm 
                          OR si.message LIKE :searchTerm
                          OR CONCAT(s.student_first_name, ' ', s.student_last_name) LIKE :searchTerm
                          OR CAST(s.student_id AS CHAR) LIKE :searchTerm)";
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
                            'admin' as recipient_name,
                            NULL as tutor_name
                        FROM admin_inbox ai
                        WHERE ai.sender_type = 'tutor' AND ai.sender_id = :tutorId";
    
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
    

    public function getTotalSentMessages($tutorId, $filter = null, $searchTerm = null) {
        $countQuery = "SELECT COUNT(*) FROM (";
        $params = [':tutorId' => $tutorId];
        
        if ($filter === 'student') {
            $query = "SELECT si.inbox_id
                      FROM student_inbox si
                      JOIN student s ON si.student_id = s.student_id
                      WHERE si.sender_type = 'tutor' AND sender_id = :tutorId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (si.subject LIKE :searchTerm 
                          OR si.message LIKE :searchTerm
                          OR CONCAT(s.student_first_name, ' ', s.student_last_name) LIKE :searchTerm
                          OR CAST(s.student_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
        } elseif ($filter === 'admin') {
            $query = "SELECT ai.inbox_id
                      FROM admin_inbox ai
                      WHERE ai.sender_type = 'tutor' AND sender_id = :tutorId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (ai.subject LIKE :searchTerm 
                          OR ai.message LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
        } else {
            $query = "SELECT si.inbox_id
                      FROM student_inbox si
                      JOIN student s ON si.student_id = s.student_id
                      WHERE si.sender_type = 'tutor' AND sender_id = :tutorId";
    
            if (!empty($searchTerm)) {
                $query .= " AND (si.subject LIKE :searchTerm 
                          OR si.message LIKE :searchTerm
                          OR CONCAT(s.student_first_name, ' ', s.student_last_name) LIKE :searchTerm
                          OR CAST(s.student_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
    
            $query .= " UNION ALL 
                       SELECT ai.inbox_id
                       FROM admin_inbox ai
                       WHERE ai.sender_type = 'tutor' AND sender_id = :tutorId";
    
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
    

    
    public function getSentMessage($messageId, $recipientType) {
        if ($recipientType === 'student') {
            $query = "SELECT 
                        'student' as recipient_type,
                        si.inbox_id as message_id,  
                        si.student_id as recipient_id,
                        si.subject,
                        si.message,
                        si.sent_at,
                        si.status,
                        si.sender_id as tutor_id,
                        CONCAT(s.student_first_name, ' ', s.student_last_name) as recipient_name
                    FROM student_inbox si
                    JOIN student s ON si.student_id = s.student_id
                    WHERE si.inbox_id = :messageId AND si.sender_type = 'tutor'";  

        } else {
            $query = "SELECT 
                        'admin' as recipient_type,
                        ai.inbox_id as message_id,  
                        1 as recipient_id,
                        ai.subject,
                        ai.message,
                        ai.sent_at,
                        ai.status,
                        ai.sender_id as tutor_id,
                        'admin' as recipient_name
                    FROM admin_inbox ai
                    WHERE ai.inbox_id = :messageId AND ai.sender_type = 'tutor'";  
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':messageId', $messageId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function getUnreadMessageCount($tutorId) {
        $query = "SELECT COUNT(*) FROM tutor_inbox WHERE status = 'unread' AND tutor_id = :tutorId ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    
    


    
    public function getStudentReplies($inboxId) {
        $query = "SELECT sir.*, s.student_first_name, s.student_last_name 
                FROM student_inbox_reply sir
                JOIN student_inbox si ON sir.inbox_id = si.inbox_id
                JOIN student s ON si.student_id = s.student_id
                WHERE si.inbox_id = :inboxId AND si.sender_type = 'tutor'
                ORDER BY sir.created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getAdminReplies($inboxId) {
        $query = "SELECT air.*, air.reply_message as message, air.replied_at as created_at, a.username
                FROM admin_inbox_reply air
                JOIN admin_inbox ai ON air.inbox_id = ai.inbox_id
                JOIN admin a ON air.admin_username = a.username
                WHERE ai.inbox_id = :inboxId AND ai.sender_type = 'tutor'
                ORDER BY air.replied_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':inboxId', $inboxId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}