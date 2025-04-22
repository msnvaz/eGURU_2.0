<?php
namespace App\Models\student;

use App\Config\Database;
use PDO;

class SessionRequestModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getPendingRequests($studentId) {
        $query = "
            SELECT 
                s.session_id,
                CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as tutor_name,
                sub.subject_name as subject,
                s.session_status,
                s.scheduled_date,
                s.schedule_time
            FROM session s
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN subject sub ON s.subject_id = sub.subject_id
            WHERE s.student_id = ? 
            AND s.session_status = 'requested'
            ORDER BY s.scheduled_date ASC, s.schedule_time ASC
        ";
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$studentId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('Database error in getPendingRequests: ' . $e->getMessage());
            return [];
        }
    }
    
    public function getRequestResults($studentId) {
        $query = "
            SELECT 
                s.session_id,
                CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as tutor_name,
                t.tutor_profile_photo,
                sub.subject_name as subject,
                s.session_status,
                s.scheduled_date,
                s.schedule_time,
                s.meeting_link
            FROM session s
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN subject sub ON s.subject_id = sub.subject_id
            WHERE s.student_id = ? 
            AND s.session_status IN ('scheduled', 'completed', 'cancelled', 'rejected')
            ORDER BY 
                CASE 
                    WHEN s.session_status = 'scheduled' THEN 1
                    WHEN s.session_status = 'completed' THEN 2
                    ELSE 3
                END,
                s.scheduled_date DESC, 
                s.schedule_time DESC
        ";
    
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$studentId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('Database error in getRequestResults: ' . $e->getMessage());
            return [];
        }
    }
    
    public function cancelRequest($sessionId, $studentId) {
        $query = "
            UPDATE session 
            SET session_status = 'cancelled'
            WHERE session_id = ? AND student_id = ? AND session_status = 'requested'
        ";

        try {
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$sessionId, $studentId]);
            return $result && $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log('Database error in cancelRequest: ' . $e->getMessage());
            return false;
        }
    }

    public function getSessionDetails($sessionId, $studentId) {
        $query = "
            SELECT 
                s.session_id,
                CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) as tutor_name,
                t.tutor_profile_photo,
                sub.subject_name as subject,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                s.meeting_link
            FROM session s
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN subject sub ON s.subject_id = sub.subject_id
            WHERE s.session_id = ? AND s.student_id = ?
        ";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$sessionId, $studentId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('Database error in getSessionDetails: ' . $e->getMessage());
            return null;
        }
    }
}