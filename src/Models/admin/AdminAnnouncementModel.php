<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class AdminAnnouncementModel {
    private $conn;

    public function __construct() {
        try {
            $db = new Database();
            $this->conn = $db->connect();
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new \Exception("Unable to connect to the database");
        }
    }

    // Create a new announcement
    public function createAnnouncement($title, $announcement) {
        try {
            if (empty(trim($title)) || empty(trim($announcement))) {
                throw new \InvalidArgumentException("Title and announcement cannot be empty");
            }

            $sql = "INSERT INTO announcement (title, announcement, status, created_at, updated_at) 
                    VALUES (:title, :announcement, 'active', NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':announcement', $announcement);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create announcement error: " . $e->getMessage());
            return false;
        }
    }

    // Get all active announcements
    public function getActiveAnnouncements($page = 1, $limit = 10) {
        try {
            $offset = ($page - 1) * $limit;

            $countSql = "SELECT COUNT(*) FROM announcement WHERE status = 'active'";
            $countStmt = $this->conn->prepare($countSql);
            $countStmt->execute();
            $totalAnnouncements = $countStmt->fetchColumn();

            $sql = "SELECT * FROM announcement 
                    WHERE status = 'active' 
                    ORDER BY created_at DESC 
                    LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            return [
                'announcements' => $stmt->fetchAll(PDO::FETCH_ASSOC),
                'total' => $totalAnnouncements,
                'page' => $page,
                'limit' => $limit
            ];
        } catch (PDOException $e) {
            error_log("Get announcements error: " . $e->getMessage());
            return [
                'announcements' => [],
                'total' => 0,
                'page' => $page,
                'limit' => $limit
            ];
        }
    }

    // Get a single announcement by ID
    public function getAnnouncementById($announce_id) {
        try {
            $sql = "SELECT * FROM announcement WHERE announce_id = :announce_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':announce_id', $announce_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get announcement by ID error: " . $e->getMessage());
            return null;
        }
    }

    // Update an announcement
    public function updateAnnouncement($announce_id, $title, $announcement) {
        try {
            if (empty(trim($title)) || empty(trim($announcement))) {
                throw new \InvalidArgumentException("Title and announcement cannot be empty");
            }
    
            $existing = $this->getAnnouncementById($announce_id);
            if (!$existing) {
                error_log("Announcement with ID $announce_id not found.");
                return false;
            }
    
            $sql = "UPDATE announcement 
                    SET title = :title, announcement = :announcement, updated_at = NOW() 
                    WHERE announce_id = :announce_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':announcement', $announcement);
            $stmt->bindParam(':announce_id', $announce_id, PDO::PARAM_INT);
    
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update announcement error: " . $e->getMessage());
            return false;
        } catch (\InvalidArgumentException $e) {
            error_log("Invalid input for announcement update: " . $e->getMessage());
            return false;
        }
    }
    
    // Soft delete an announcement (set status to inactive)
    public function softDeleteAnnouncement($announce_id) {
        try {
            $existing = $this->getAnnouncementById($announce_id);
            if (!$existing) {
                return false;
            }

            $sql = "UPDATE announcement SET status = 'inactive' WHERE announce_id = :announce_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':announce_id', $announce_id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Soft delete announcement error: " . $e->getMessage());
            return false;
        }
    }
}
