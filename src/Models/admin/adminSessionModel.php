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
                s.scheduled_date,
                s.scheduled_time,
                s.progress,
                s.feedback,
                s.status,
                st.firstname AS student_firstname,
                st.lastname AS student_lastname,
                st.email AS student_email,
                t.name AS tutor_name,
                t.email AS tutor_email,
                sub.subject_name,
                sub.grade_6,
                sub.grade_7,
                sub.grade_8,
                sub.grade_9,
                sub.grade_10,
                sub.grade_11
            FROM sessions s
            LEFT JOIN student st ON s.student_id = st.id
            LEFT JOIN tutors t ON s.tutor_id = t.tutor_id
            LEFT JOIN subjects sub ON s.subject_id = sub.subject_id
            ORDER BY s.session_id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                s.scheduled_date,
                s.scheduled_time,
                s.progress,
                s.feedback,
                s.status,
                st.firstname AS student_firstname,
                st.lastname AS student_lastname,
                st.email AS student_email,
                t.name AS tutor_name,
                t.email AS tutor_email,
                sub.subject_name,
                sub.grade_6,
                sub.grade_7,
                sub.grade_8,
                sub.grade_9,
                sub.grade_10,
                sub.grade_11
            FROM sessions s
            LEFT JOIN student st ON s.student_id = st.id
            LEFT JOIN tutors t ON s.tutor_id = t.tutor_id
            LEFT JOIN subjects sub ON s.subject_id = sub.subject_id
            WHERE st.firstname LIKE :search 
            OR st.lastname LIKE :search
            OR t.name LIKE :search
            OR st.email LIKE :search
            OR t.email LIKE :search
            ORDER BY s.session_id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $searchTerm = "%$searchTerm%";
            $stmt->bindParam(':search', $searchTerm);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error searching sessions: ' . $e->getMessage());
            return [];
        }
    }
}