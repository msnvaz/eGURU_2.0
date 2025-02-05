<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;

class AdminInboxModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->Connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    public function getFilteredMessages($filter = 'all', $search = '', $sort = 'newest') {
        $query = "SELECT * FROM admin_inbox WHERE 1=1";

        // Filtering conditions
        if ($filter === 'students') {
            $query .= " AND sender_type = 'student'";
        } elseif ($filter === 'teachers') {
            $query .= " AND sender_type = 'teacher'";
        } elseif ($filter === 'unread') {
            $query .= " AND status = 'unread'";
        } elseif ($filter === 'flagged') {
            $query .= " AND is_flagged = 1";
        }

        // Search condition
        if (!empty($search)) {
            $query .= " AND (sender_name LIKE :search OR subject LIKE :search OR message LIKE :search)";
        }

        // Sorting
        switch ($sort) {
            case 'oldest':
                $query .= " ORDER BY timestamp ASC";
                break;
            case 'priority':
                $query .= " ORDER BY priority DESC, timestamp DESC";
                break;
            default:
                $query .= " ORDER BY timestamp DESC";
        }

        $stmt = $this->conn->prepare($query);

        // Bind search parameter if exists
        if (!empty($search)) {
            $searchParam = "%{$search}%";
            $stmt->bindParam(':search', $searchParam);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendMessage($data) {
        $query = "INSERT INTO admin_inbox (sender_type, sender_name, subject, message, timestamp) VALUES (:sender_type, :sender_name, :subject, :message, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sender_type', $data['sender_type']);
        $stmt->bindParam(':sender_name', $data['sender_name']);
        $stmt->bindParam(':subject', $data['subject']);
        $stmt->bindParam(':message', $data['message']);
        return $stmt->execute();
    }

    // Additional methods for managing messages can be added here
}
