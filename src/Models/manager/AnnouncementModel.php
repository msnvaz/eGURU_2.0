<?php

namespace App\Models\manager;

use App\Config\Database;
use PDO;

class AnnouncementModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if (!$this->conn) {
            die("Database connection failed.");
        }
    }

    // Create a new announcement
    public function createAnnouncement($announcement) {
        $sql = "INSERT INTO announcement (announcement) VALUES (:announcement)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':announcement', $announcement);
        
        return $stmt->execute();
    }

    // Get all announcements
    public function getAllAnnouncements() {
        $sql = "SELECT * FROM announcement";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single announcement by ID
    public function getAnnouncementById($announce_id) {
        $sql = "SELECT * FROM announcement WHERE announce_id = :announce_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':announce_id', $announce_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update an announcement
    public function updateAnnouncement($announce_id, $announcement) {
        $sql = "UPDATE announcement SET announcement = :announcement WHERE announce_id = :announce_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':announcement', $announcement);
        $stmt->bindParam(':announce_id', $announce_id);
        
        return $stmt->execute();
    }

    // Delete an announcement
    public function deleteAnnouncement($announce_id) {
        $sql = "DELETE FROM announcement WHERE announce_id = :announce_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':announce_id', $announce_id);
        
        return $stmt->execute();
    }
}
