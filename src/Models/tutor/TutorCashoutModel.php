<?php

namespace App\Models\tutor;

use App\Config\Database;
use PDO;

class TutorCashoutModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Get tutor information including points
     * 
     * @param int $tutorId The tutor ID
     * @return array|bool Tutor information or false if not found
     */
    public function getTutorInfo($tutorId) {
        try {
            $sql = "SELECT * FROM tutor WHERE tutor_id = :tutorId";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':tutorId', $tutorId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            
            error_log("Error retrieving tutor info: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get cashout history for a tutor
     * 
     * @param int $tutorId The tutor ID
     * @return array Cashout history
     */
    public function getCashoutHistory($tutorId) {
        try {
            $sql = "SELECT * FROM tutor_point_cashout WHERE tutor_id = :tutorId ORDER BY cashout_id DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':tutorId', $tutorId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Log error
            error_log("Error retrieving cashout history: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Store cashout details in the database
     * 
     * @param int $tutorId The tutor ID
     * @param int $pointAmount The amount of points cashed out
     * @param float $cashValue The cash value of the cashout
     * @param string $transactionId The bank transaction ID
     * @return bool Whether the operation was successful
     */
    public function storeCashout($tutorId, $pointAmount, $cashValue, $transactionId) {
        try {
            $sql = "INSERT INTO tutor_point_cashout (tutor_id, point_amount, cash_value, bank_transaction_id) 
                    VALUES (:tutorId, :pointAmount, :cashValue, :transactionId)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':tutorId', $tutorId, PDO::PARAM_INT);
            $stmt->bindParam(':pointAmount', $pointAmount, PDO::PARAM_INT);
            $stmt->bindParam(':cashValue', $cashValue, PDO::PARAM_STR);
            $stmt->bindParam(':transactionId', $transactionId, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            
            error_log("Error storing cashout: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update tutor points after cashout
     * 
     * @param int $tutorId The tutor ID
     * @param int $newPointsAmount The new points amount after cashout
     * @return bool Whether the operation was successful
     */
    public function updateTutorPoints($tutorId, $newPointsAmount) {
        try {
            $sql = "UPDATE tutor SET tutor_points = :points WHERE tutor_id = :tutorId";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':points', $newPointsAmount, PDO::PARAM_INT);
            $stmt->bindParam(':tutorId', $tutorId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            
            error_log("Error updating tutor points: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the cash value of a point from admin settings
     * 
     * @return float The cash value of a point
     */
    public function getPointValue() {
        try {
            $sql = "SELECT admin_setting_value FROM admin_settings WHERE admin_setting_name = 'point_value'";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (float)$result['admin_setting_value'] : 10.0; // Default to 10 if not found
        } catch (\PDOException $e) {
            
            error_log("Error retrieving point value: " . $e->getMessage());
            return 10.0; 
        }
    }

    /**
     * Get the platform fee percentage from admin settings
     * 
     * @return float The platform fee percentage
     */
    public function getPlatformFee() {
        try {
            $sql = "SELECT admin_setting_value FROM admin_settings WHERE admin_setting_name = 'platform_fee'";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (float)$result['admin_setting_value'] : 5.0; 
        } catch (\PDOException $e) {
            
            error_log("Error retrieving platform fee: " . $e->getMessage());
            return 5.0; 
        }
    }
}