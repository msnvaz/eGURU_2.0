<?php
namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class adminSessionModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    // Fetch all sessions with detailed information
    public function getAllSessions() {
        try {
            $sql = "SELECT 
                s.session_id,
                s.student_id,
                s.tutor_id,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                st.student_first_name,
                st.student_last_name,
                st.student_email,
                t.tutor_first_name,
                t.tutor_last_name,
                t.tutor_email,
                sf.student_feedback,
                sp.payment_status,
                sub.subject_name  -- Added subject name
            FROM session s
            LEFT JOIN student st ON s.student_id = st.student_id
            LEFT JOIN tutor t ON s.tutor_id = t.tutor_id
            LEFT JOIN session_feedback sf ON s.session_id = sf.session_id
            LEFT JOIN session_payment sp ON s.session_id = sp.session_id
            LEFT JOIN subject sub ON s.subject_id = sub.subject_id  -- Assuming there's a subjects table
            ORDER BY s.session_id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Fetched sessions: ' . print_r($sessions, true)); // Debugging statement
            return $sessions;
        } catch (PDOException $e) {
            error_log('Error fetching all sessions: ' . $e->getMessage());
            return [];
        }
    }

    // Search sessions
    public function searchSessions($searchTerm) {
        try {
            $sql = "SELECT 
                s.session_id,
                s.student_id,
                s.tutor_id,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                st.student_first_name,
                st.student_last_name,
                st.student_email,
                t.tutor_first_name,
                t.tutor_last_name,
                t.tutor_email,
                sf.student_feedback,
                sp.payment_status,
                sub.subject_name  -- Added subject name
            FROM session s
            LEFT JOIN student st ON s.student_id = st.student_id
            LEFT JOIN tutor t ON s.tutor_id = t.tutor_id
            LEFT JOIN session_feedback sf ON s.session_id = sf.session_id
            LEFT JOIN session_payment sp ON s.session_id = sp.session_id
            LEFT JOIN subject sub ON s.subject_id = sub.subject_id  -- Assuming there's a subjects table
            WHERE LOWER(st.student_first_name) LIKE LOWER(:search)
            OR LOWER(st.student_last_name) LIKE LOWER(:search)
            OR LOWER(t.tutor_first_name) LIKE LOWER(:search)
            OR LOWER(t.tutor_last_name) LIKE LOWER(:search)
            OR CAST(s.session_id AS CHAR) LIKE :search
            ORDER BY s.session_id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $searchTerm = "%$searchTerm%";
            $stmt->bindParam(':search', $searchTerm);
            $stmt->execute();
            
            $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Fetched sessions for search term "' . $searchTerm . '": ' . print_r($sessions, true)); // Debugging statement
            return $sessions;
        } catch (PDOException $e) {
            error_log('Error searching sessions: ' . $e->getMessage());
            return [];
        }
    }
}
