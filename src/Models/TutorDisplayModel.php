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
                tutors.tutor_id,
                tutors.first_name, 
                tutors.last_name, 
                tutors.sessions_done
            FROM 
                tutors
            ORDER BY 
                sessions_done DESC
        ");
        $query->execute();
        $tutors = $query->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($tutors as &$tutor) {
            $subjectQuery = $this->conn->prepare("
                SELECT DISTINCT subjects.subject_name 
                FROM tutor_subject_grade
                JOIN subjects ON tutor_subject_grade.subject_id = subjects.subject_id
                WHERE tutor_subject_grade.tutor_id = :tutor_id
            ");
            $subjectQuery->bindParam(':tutor_id', $tutor['id']);
            $subjectQuery->execute();
            $tutor['subjects'] = $subjectQuery->fetchAll(PDO::FETCH_COLUMN);
        }
    
        return $tutors;
    }
    
    
    

    // Fetch the names of tutors with the maximum count of sessions with status 'scheduled'
    public function getScheduledTutors() {
        $query = $this->conn->prepare("
            SELECT 
                t.tutor_id,
                CONCAT(t.first_name, ' ', t.last_name) AS name,  -- Concatenating first_name & last_name
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
        $tutors = $query->fetchAll(PDO::FETCH_ASSOC);
    
        // Fetch subjects for each tutor
        foreach ($tutors as &$tutor) {
            $subjectQuery = $this->conn->prepare("
                SELECT DISTINCT subjects.subject_name 
                FROM tutor_subject_grade
                JOIN subjects ON tutor_subject_grade.subject_id = subjects.subject_id
                WHERE tutor_subject_grade.tutor_id = :tutor_id
            ");
            $subjectQuery->bindParam(':tutor_id', $tutor['tutor_id']);
            $subjectQuery->execute();
            $tutor['subjects'] = $subjectQuery->fetchAll(PDO::FETCH_COLUMN);
        }
    
        return $tutors;
    }
    
    
}
