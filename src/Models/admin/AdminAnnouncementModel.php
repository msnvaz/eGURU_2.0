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
    public function createAnnouncement($announcement, $status = 'active') {
        try {
            if (empty(trim($announcement))) {
                throw new \InvalidArgumentException("Announcement cannot be empty");
            }

            $sql = "INSERT INTO announcement (announcement, status, created_at, updated_at) 
                    VALUES (:announcement, :status, NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':announcement', $announcement);
            $stmt->bindParam(':status', $status);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create announcement error: " . $e->getMessage());
            return false;
        }
    }

    // Get all announcements (default: active ones)
    public function getAllAnnouncements($page = 1, $limit = 10, $statusFilter = 'active') {
        try {
            $offset = ($page - 1) * $limit;
            $statusCondition = $statusFilter ? "WHERE status = :status" : "";

            $countSql = "SELECT COUNT(*) FROM announcement $statusCondition";
            $countStmt = $this->conn->prepare($countSql);
            if ($statusFilter) {
                $countStmt->bindParam(':status', $statusFilter);
            }
            $countStmt->execute();
            $totalAnnouncements = $countStmt->fetchColumn();

            $sql = "SELECT * FROM announcement $statusCondition 
                    ORDER BY created_at DESC 
                    LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            if ($statusFilter) {
                $stmt->bindParam(':status', $statusFilter);
            }
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
    public function updateAnnouncement($announce_id, $announcement, $status) {
        try {
            if (empty(trim($announcement))) {
                throw new \InvalidArgumentException("Announcement cannot be empty");
            }
    
            $existing = $this->getAnnouncementById($announce_id);
            if (!$existing) {
                error_log("Announcement with ID $announce_id not found.");
                return false;
            }
    
            $sql = "UPDATE announcement 
                    SET announcement = :announcement, status = :status, updated_at = NOW() 
                    WHERE announce_id = :announce_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':announcement', $announcement);
            $stmt->bindParam(':status', $status);
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
    
    // Soft delete an announcement (Set status to 'inactive')
    public function softDeleteAnnouncement($announce_id) {
        try {
            $existing = $this->getAnnouncementById($announce_id);
            if (!$existing) {
                return false;
            }

            $sql = "UPDATE announcement SET status = 'inactive', updated_at = NOW() WHERE announce_id = :announce_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':announce_id', $announce_id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Soft delete announcement error: " . $e->getMessage());
            return false;
        }
    }
}
