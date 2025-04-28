<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class TutorDisplayModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getSuccessfulTutors() {
        $query = $this->conn->prepare("        
            SELECT 
                t.tutor_id,
                t.tutor_first_name, 
                t.tutor_last_name, 
                t.tutor_profile_photo,
                COUNT(s.session_id) AS completed_sessions
            FROM tutor t
            JOIN session s ON t.tutor_id = s.tutor_id
            WHERE s.session_status = 'completed'
            GROUP BY t.tutor_id, t.tutor_first_name, t.tutor_last_name
            ORDER BY completed_sessions DESC
            LIMIT 4
        ");
        $query->execute();
        $tutors = $query->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($tutors as &$tutor) {
            $subjectQuery = $this->conn->prepare("            
                SELECT DISTINCT sub.subject_name 
                FROM tutor_subject ts
                JOIN subject sub ON ts.subject_id = sub.subject_id
                WHERE ts.tutor_id = :tutor_id
            ");
            $subjectQuery->bindParam(':tutor_id', $tutor['tutor_id']);
            $subjectQuery->execute();
            $tutor['subjects'] = $subjectQuery->fetchAll(PDO::FETCH_COLUMN);
        }
    
        return $tutors;
    }

    public function getScheduledTutors() {
        $query = $this->conn->prepare("        
            SELECT 
                t.tutor_id,
                t.tutor_first_name,
                t.tutor_last_name,
                t.tutor_profile_photo,
                COUNT(s.session_id) AS scheduled_sessions
            FROM tutor t
            JOIN session s ON t.tutor_id = s.tutor_id
            WHERE s.session_status = 'scheduled'
            GROUP BY t.tutor_id, t.tutor_first_name, t.tutor_last_name
            ORDER BY scheduled_sessions DESC
            LIMIT 4
        ");
        $query->execute();
        $tutors = $query->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($tutors as &$tutor) {
            $subjectQuery = $this->conn->prepare("            
                SELECT DISTINCT sub.subject_name 
                FROM tutor_subject ts
                JOIN subject sub ON ts.subject_id = sub.subject_id
                WHERE ts.tutor_id = :tutor_id
            ");
            $subjectQuery->bindParam(':tutor_id', $tutor['tutor_id']);
            $subjectQuery->execute();
            $tutor['subjects'] = $subjectQuery->fetchAll(PDO::FETCH_COLUMN);
        }
    
        return $tutors;
    }
}