<?php

namespace App\Models;

use PDO;

class ForumModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Retrieves all forum messages along with student first names
    public function getAllMessages() {
        $query = "SELECT f.message_id, f.student_id, f.message, f.time, s.student_first_name
                  FROM forum f
                  JOIN student s ON f.student_id = s.id
                  ORDER BY f.time DESC";
                  
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
