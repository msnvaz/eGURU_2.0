<?php
namespace App\Models;

use App\Config\Database;


use PDO;
use PDOException;

class DisplayAnnouncementModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Retrieve all announcements
    public function getAllAnnouncements() {
        try {
            $query = "SELECT title, announcement FROM announcement ORDER BY announce_id DESC"; 
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}
