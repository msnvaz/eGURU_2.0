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

    public function getPendingRequestsByStudent($student_id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT 
                    sr.student_id as requested_id,
                    tn.first_name AS tutor_name,

                    tn.subject,
                    tn.grade,
                    sr.requested_date,
                    sr.status
                FROM session_requests sr
                JOIN tutor_new tn ON sr.tutor_id = tn.tutor_id
                WHERE sr.student_id = ? 
                ORDER BY sr.requested_date DESC
            ");
            $stmt->execute([$student_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function cancelRequest($request_id, $student_id) {
        try {
            $stmt = $this->conn->prepare("
                UPDATE tutor_requests
                SET status = 'cancelled'
                WHERE id = ? AND student_id = ?
            ");
            return $stmt->execute([$request_id, $student_id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
