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

            $sql = "INSERT INTO announcement (announcement, status, created_at, updated_at) VALUES (:announcement, :status, NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':announcement', $announcement);
            $stmt->bindParam(':status', $status);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create announcement error: " . $e->getMessage());
            return false;
        }
    }

    // Get all announcements with optional pagination
    public function getAllAnnouncements($page = 1, $limit = 10, $statusFilter = null) {
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

            $sql = "SELECT * FROM announcement $statusCondition ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->conn->prepare($sql);
            if ($statusFilter) {
                $stmt->bindParam(':status', $statusFilter);
            }
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();

            $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'announcements' => $announcements,
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
            // Check if the announcement text is not empty
            if (empty(trim($announcement))) {
                throw new \InvalidArgumentException("Announcement cannot be empty");
            }
    
            // Fetch the existing announcement by ID
            $existing = $this->getAnnouncementById($announce_id);
            if (!$existing) {
                // If the announcement does not exist, log the error and return false
                error_log("Announcement with ID $announce_id not found.");
                return false;
            }
    
            // Prepare the SQL statement for updating the announcement
            $sql = "UPDATE announcement SET announcement = :announcement, status = :status, updated_at = NOW() WHERE announce_id = :announce_id";
            $stmt = $this->conn->prepare($sql);
    
            // Bind the parameters to the statement
            $stmt->bindParam(':announcement', $announcement);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':announce_id', $announce_id, PDO::PARAM_INT);
    
            // Execute the statement and check if it was successful
            if ($stmt->execute()) {
                // Check if any rows were affected (updated)
                if ($stmt->rowCount() > 0) {
                    return true;  // Successful update
                } else {
                    // If no rows were affected, log that the update had no changes
                    error_log("No changes made to the announcement with ID $announce_id.");
                    return false;
                }
            } else {
                // If the query execution fails, log the error
                error_log("Update query execution failed for announcement ID $announce_id.");
                return false;
            }
        } catch (PDOException $e) {
            // Log any exceptions thrown during the process
            error_log("Update announcement error: " . $e->getMessage());
            return false;
        } catch (\InvalidArgumentException $e) {
            // Log any invalid argument exceptions (like empty announcement text)
            error_log("Invalid input for announcement update: " . $e->getMessage());
            return false;
        }
    }
    
    // Delete an announcement
    public function deleteAnnouncement($announce_id) {
        try {
            $existing = $this->getAnnouncementById($announce_id);
            if (!$existing) {
                return false;
            }

            $sql = "DELETE FROM announcement WHERE announce_id = :announce_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':announce_id', $announce_id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete announcement error: " . $e->getMessage());
            return false;
        }
    }
}
