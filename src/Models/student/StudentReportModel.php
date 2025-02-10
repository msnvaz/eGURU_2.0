<?php
namespace App\Models\student;

use App\Config\Database;
use PDO;

class StudentReportModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function get_tutors() {
        $sql = "SELECT tutor_id, name, subject, tutor_level, grade, availability, rating, hour_fees 
                FROM tutor_new 
                ORDER BY name";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_tutor_details($tutor_id) {
        $sql = "SELECT tn.tutor_id, tn.name, tn.availability, tn.rating, tn.hour_fees,
                       ts.subject, ts.grade, ts.subject_id
                FROM tutor_new tn
                JOIN tutor_subjects ts ON tn.tutor_id = ts.tutor_id
                WHERE tn.tutor_id = ?
                ORDER BY ts.subject, ts.grade";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$tutor_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_report() {
        $sql = "SELECT r.*, t.name as tutor_name 
                FROM report_tutor r 
                JOIN tutor_new t ON r.tutor_id = t.tutor_id 
                ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save_report($student_id, $tutor_id, $issue_type, $description) {
        $sql = "INSERT INTO report_tutor (student_id, tutor_id, issue_type, description, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, 'Pending', NOW(), NOW())";
    
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$student_id, $tutor_id, $issue_type, $description]);
    }
}
