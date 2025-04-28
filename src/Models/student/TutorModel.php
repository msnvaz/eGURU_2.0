<?php
namespace App\Models\student;

use App\Config\Database;
use PDO;

class TutorModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();  
    }

    public function fetchTutorById($tutor_id) {
        $stmt = $this->conn->prepare("SELECT * FROM tutor_new WHERE tutor_id = ?");
        $stmt->execute([$tutor_id]);  
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function searchTutors($grade, $subject, $experience) {
        
        error_log(sprintf(
            "Search called with - Grade: '%s', Subject: '%s', Experience: '%s'",
            $grade, $subject, $experience
        ));
    
        $sql = "SELECT * FROM tutor_new WHERE 1";
        $params = [];
    
        if (!empty($grade)) { 
            $sql .= " AND grade = ?"; 
            $params[] = $grade;
            error_log("Added grade filter: $grade");
        }
        if (!empty($subject)) { 
            $sql .= " AND subject = ?"; 
            $params[] = $subject;
            error_log("Added subject filter: $subject");
        }
        if (!empty($experience)) { 
            $sql .= " AND tutor_level = ?"; 
            $params[] = $experience;
            error_log("Added experience filter: $experience");
        }
    
        error_log("Final SQL: " . $sql);
        error_log("Parameters: " . print_r($params, true));
    
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            error_log("Query executed successfully, found " . count($results) . " results");
            error_log("First result: " . print_r(!empty($results) ? $results[0] : 'none', true));
            
            return $results;
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw $e;
        }
    }
    public function createTutorRequest($data) {
        try {
            
    
            
            $sql1 = "INSERT INTO tutor_requests (student_id, tutor_id, preferred_time, message, status) 
                    VALUES (?, ?, ?, ?, ?)";
                    
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute([
                $data['student_id'],
                $data['tutor_id'],
                $data['preferred_time'],
                $data['message'],
                $data['status']
            ]);
    
            
            $sql2 = "INSERT INTO session_requests (student_id, tutor_id, requested_date, status) 
                    VALUES (?, ?, ?, 'pending')";
                    
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([
                $data['student_id'],
                $data['tutor_id'],
                $data['preferred_time']
            ]);
    
            
            return true;
    
        } catch (\PDOException $e) {
           
            error_log("Database error: " . $e->getMessage());
            throw $e;
        }
    }
}