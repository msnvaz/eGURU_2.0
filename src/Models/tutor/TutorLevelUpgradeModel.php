<?php

namespace App\Models\tutor;

use App\Config\Database;
use PDO;

class TutorLevelUpgradeModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllTutorLevels() {
        $stmt = $this->conn->prepare("
            SELECT tutor_level_id, tutor_level, tutor_level_qualification, tutor_pay_per_hour
            FROM tutor_level
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    // Get tutor's current level from tutor table
    public function getTutorCurrentLevel($tutorId) {
        $stmt = $this->conn->prepare("SELECT tutor_level_id FROM tutor WHERE tutor_id = ?");
        $stmt->execute([$tutorId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['tutor_level_id'];
    }

    // Insert upgrade request
    public function submitUpgradeRequest($tutorId, $currentLevel, $requestedLevel, $requestBody) {
        $stmt = $this->conn->prepare("
            INSERT INTO tutor_level_upgrade (
                tutor_id, request_date, status, request_body, current_level_id, requested_level_id
            ) VALUES (?, CURDATE(), 'pending', ?, ?, ?)
        ");
        return $stmt->execute([$tutorId, $requestBody, $currentLevel, $requestedLevel]);
    }

    public function getUpgradeRequestsByTutor($tutorId) {
        $stmt = $this->conn->prepare("
            SELECT 
                ulu.*, 
                tl1.tutor_level AS current_level_name, 
                tl2.tutor_level AS requested_level_name 
            FROM tutor_level_upgrade ulu
            JOIN tutor_level tl1 ON CONVERT(ulu.current_level_id USING utf8mb4) COLLATE utf8mb4_general_ci = 
                                    CONVERT(tl1.tutor_level_id USING utf8mb4) COLLATE utf8mb4_general_ci
            JOIN tutor_level tl2 ON CONVERT(ulu.requested_level_id USING utf8mb4) COLLATE utf8mb4_general_ci = 
                                    CONVERT(tl2.tutor_level_id USING utf8mb4) COLLATE utf8mb4_general_ci
            WHERE ulu.tutor_id = ?
            ORDER BY ulu.request_date DESC
        ");
        $stmt->execute([$tutorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function cancelUpgradeRequest($requestId) {
        $stmt = $this->conn->prepare("
            UPDATE tutor_level_upgrade 
            SET status = 'cancelled', status_updated_date = NOW() 
            WHERE request_id = ?
        ");
        return $stmt->execute([$requestId]);
    }
    

}
