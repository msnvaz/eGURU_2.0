<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class ForumModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllMessages() {
        $query = "SELECT f.*, s.name 
                  FROM forum f
                  JOIN student s ON f.student_id = s.id
                  ORDER BY f.time DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
