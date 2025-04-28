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

    public function getAnnouncements($offset = 0, $limit = 5) {
        try {
            $query = "SELECT title, announcement, updated_at FROM announcement 
                      ORDER BY announce_id DESC LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}
