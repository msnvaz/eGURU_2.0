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
                t.first_name AS tutor_name,
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
                t.first_name AS tutor_name,
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
            WHERE LOWER(st.firstname) LIKE LOWER(:search)
            OR LOWER(st.lastname) LIKE LOWER(:search)
            OR LOWER(t.first_name) LIKE LOWER(:search)
            OR LOWER(st.email) LIKE LOWER(:search)
            OR LOWER(t.email) LIKE LOWER(:search)
            OR LOWER(sub.subject_name) LIKE LOWER(:search)
            OR CAST(s.session_id AS CHAR) LIKE :search

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
