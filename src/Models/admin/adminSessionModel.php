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

    public function getAllSessions($status = '') {
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
                sub.subject_name
            FROM session s
            LEFT JOIN student st ON s.student_id = st.student_id
            LEFT JOIN tutor t ON s.tutor_id = t.tutor_id
            LEFT JOIN session_feedback sf ON s.session_id = sf.session_id
            LEFT JOIN session_payment sp ON s.session_id = sp.session_id
            LEFT JOIN subject sub ON s.subject_id = sub.subject_id"
            . ($status ? " WHERE s.session_status = :status" : "") . "
            ORDER BY s.session_id DESC";
            
            $stmt = $this->conn->prepare($sql);
            if ($status) $stmt->bindParam(':status', $status);
            $stmt->execute();
            
            $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Model: getAllSessions fetched ' . count($sessions) . ' records');
            return $sessions;
        } catch (PDOException $e) {
            error_log('Error fetching all sessions: ' . $e->getMessage());
            return [];
        }
    }

    public function filterSessions($startDate, $endDate, $tutorId, $studentId, $status = '') {
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
                sub.subject_name
            FROM session s
            LEFT JOIN student st ON s.student_id = st.student_id
            LEFT JOIN tutor t ON s.tutor_id = t.tutor_id
            LEFT JOIN session_feedback sf ON s.session_id = sf.session_id
            LEFT JOIN session_payment sp ON s.session_id = sp.session_id
            LEFT JOIN subject sub ON s.subject_id = sub.subject_id
            WHERE 1=1
            " . ($startDate ? "AND s.scheduled_date >= :start_date " : "") . "
            " . ($endDate ? "AND s.scheduled_date <= :end_date " : "") . "
            " . ($tutorId ? "AND s.tutor_id = :tutor_id " : "") . "
            " . ($studentId ? "AND s.student_id = :student_id " : "") . "
            " . ($status ? "AND s.session_status = :status " : "") . "
            ORDER BY s.session_id DESC";
            
            $stmt = $this->conn->prepare($sql);
            
            if ($startDate) $stmt->bindParam(':start_date', $startDate);
            if ($endDate) $stmt->bindParam(':end_date', $endDate);
            if ($tutorId) $stmt->bindParam(':tutor_id', $tutorId);
            if ($studentId) $stmt->bindParam(':student_id', $studentId);
            if ($status) $stmt->bindParam(':status', $status);
            
            $stmt->execute();
            
            $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Model: filterSessions fetched ' . count($sessions) . ' records');
            return $sessions;
        } catch (PDOException $e) {
            error_log('Error filtering sessions: ' . $e->getMessage());
            return [];
        }
    }

    public function searchSessions($searchTerm, $status = '') {
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
                sub.subject_name
            FROM session s
            LEFT JOIN student st ON s.student_id = st.student_id
            LEFT JOIN tutor t ON s.tutor_id = t.tutor_id
            LEFT JOIN session_feedback sf ON s.session_id = sf.session_id
            LEFT JOIN session_payment sp ON s.session_id = sp.session_id
            LEFT JOIN subject sub ON s.subject_id = sub.subject_id
            WHERE (LOWER(st.student_first_name) LIKE LOWER(:search)
            OR LOWER(st.student_last_name) LIKE LOWER(:search)
            OR LOWER(t.tutor_first_name) LIKE LOWER(:search)
            OR LOWER(t.tutor_last_name) LIKE LOWER(:search)
            OR LOWER(st.student_email) LIKE LOWER(:search)
            OR LOWER(t.tutor_email) LIKE LOWER(:search)
            OR CAST(s.session_id AS CHAR) LIKE :search)"
            . ($status ? " AND s.session_status = :status" : "") . "
            ORDER BY s.session_id DESC";
            
            $stmt = $this->conn->prepare($sql);
            $searchParam = "%$searchTerm%"; 
            
            $stmt->bindParam(':search', $searchParam);
            if ($status) $stmt->bindParam(':status', $status);
            $stmt->execute();
            
            $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Model: searchSessions found ' . count($sessions) . ' matching records');
            return $sessions;
        } catch (PDOException $e) {
            error_log('Error searching sessions: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllTutors() {
        try {
            $sql = "SELECT tutor_id, 
                    CONCAT(tutor_first_name, ' ', tutor_last_name) AS tutor_full_name 
                    FROM tutor 
                    ORDER BY tutor_first_name, tutor_last_name";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching tutors: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllStudents() {
        try {
            $sql = "SELECT student_id, 
                    CONCAT(student_first_name, ' ', student_last_name) AS student_full_name 
                    FROM student 
                    ORDER BY student_first_name, student_last_name";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching students: ' . $e->getMessage());
            return [];
        }
    }
}