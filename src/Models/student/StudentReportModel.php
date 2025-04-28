<?php

namespace App\Models\student;

use App\Config\Database;
use PDO;

class StudentReportModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }
    
    public function getTutorsWithCompletedSessions($studentId) {
        try {
            $query = "SELECT DISTINCT t.tutor_id, 
                      CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as name,
                      COUNT(s.session_id) as completed_sessions
                      FROM tutor t
                      JOIN session s ON s.tutor_id = t.tutor_id
                      WHERE s.student_id = :student_id
                      AND s.session_status = 'completed'
                      GROUP BY t.tutor_id, name
                      ORDER BY name";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            
            error_log("Database error in getTutorsWithCompletedSessions: " . $e->getMessage());
            return [];
        }
    }

    public function getPreviousReports($studentId) {
        try {
            $query = "SELECT r.report_id, r.report_time as created_at, 
                      CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as tutor_name,
                      r.issue_type, r.description, 
                      CASE 
                          WHEN r.report_time > DATE_SUB(NOW(), INTERVAL 24 HOUR) THEN 'Pending'
                          ELSE 'Under Review'
                      END as status
                      FROM tutor_report r
                      JOIN tutor t ON r.tutor_id = t.tutor_id
                      WHERE r.student_id = :student_id
                      ORDER BY r.report_time DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error in getPreviousReports: " . $e->getMessage());
            return [];
        }
    }

    public function hasCompletedSession($studentId, $tutorId) {
        try {
            $query = "SELECT COUNT(*) as count
                      FROM session
                      WHERE student_id = :student_id
                      AND tutor_id = :tutor_id
                      AND session_status = 'completed'";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmt->bindParam(':tutor_id', $tutorId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (\PDOException $e) {
            error_log("Database error in hasCompletedSession: " . $e->getMessage());
            return false;
        }
    }

    public function saveReport($studentId, $tutorId, $issueType, $description) {
        try {
            $query = "INSERT INTO tutor_report (tutor_id, student_id, description, issue_type, report_time)
                      VALUES (:tutor_id, :student_id, :description, :issue_type, NOW())";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tutor_id', $tutorId, PDO::PARAM_INT);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':issue_type', $issueType, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Database error in saveReport: " . $e->getMessage());
            return false;
        }
    }

    public function getTutorDetails($tutorId) {
        try {
            $query = "SELECT 
                      CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as name,
                      s.subject_name as subject,
                      tl.tutor_level as tutor_level,
                      COALESCE(
                          (SELECT AVG(sf.session_rating) 
                           FROM session_feedback sf 
                           JOIN session s ON sf.session_id = s.session_id 
                           WHERE s.tutor_id = t.tutor_id), 
                          0
                      ) as rating,
                      tl.tutor_pay_per_hour as hour_fees,
                      CASE 
                          WHEN t.tutor_log = 'online' THEN 'available'
                          ELSE 'unavailable'
                      END as availability
                      FROM tutor t
                      JOIN tutor_level tl ON t.tutor_level_id = tl.tutor_level_id
                      JOIN tutor_subject ts ON t.tutor_id = ts.tutor_id
                      JOIN subject s ON ts.subject_id = s.subject_id
                      WHERE t.tutor_id = :tutor_id
                      LIMIT 1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tutor_id', $tutorId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error in getTutorDetails: " . $e->getMessage());
            return null;
        }
    }
}