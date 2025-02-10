<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class TutorDisplayModel {
    private $conn;

    public function __construct() {
        // Create a new database connection
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Fetch the names of tutors who have completed sessions
    public function getSuccessfulTutors() {
        $query = $this->conn->prepare("
            SELECT 
                DISTINCT t.name, 
                COUNT(s.tutor_id) AS tutor_count
            FROM 
                tutors t
            JOIN 
                sessions s ON t.tutor_id = s.tutor_id
            WHERE 
                s.progress = :progress
            GROUP BY 
                s.tutor_id
            ORDER BY 
                tutor_count DESC
        ");
        $query->execute(['progress' => 'completed']);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch the names of tutors with the maximum count of sessions with status 'scheduled'
    public function getScheduledTutors() {
        $query = $this->conn->prepare("
            SELECT 
                t.name, 
                COUNT(s.tutor_id) AS session_count
            FROM 
                tutors t
            JOIN 
                sessions s ON t.tutor_id = s.tutor_id
            WHERE 
                s.status = :status
            GROUP BY 
                t.tutor_id
            ORDER BY 
                session_count DESC
        ");
        $query->execute(['status' => 'scheduled']);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
