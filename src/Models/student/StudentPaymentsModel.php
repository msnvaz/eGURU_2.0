<?php

namespace App\Models\student;

use App\Config\Database;
use PDO;

class StudentPaymentsModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Store payment details in the database
     * 
     * @param int $studentId The student ID
     * @param int $pointAmount The amount of points purchased
     * @param int $cashValue The cash value of the purchase
     * @param string $transactionId The bank transaction ID
     * @return bool Whether the operation was successful
     */
    /**
 * Store payment details in the database
 */
public function storePayment($studentId, $pointAmount, $cashValue, $transactionId) {
    try {
        $sql = "INSERT INTO student_point_purchase (student_id, point_amount, cash_value, bank_transaction_id, transaction_date, transaction_time) 
                VALUES (:studentId, :pointAmount, :cashValue, :transactionId, CURDATE(), CURTIME())";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->bindParam(':pointAmount', $pointAmount, PDO::PARAM_INT);
        $stmt->bindParam(':cashValue', $cashValue, PDO::PARAM_INT);
        $stmt->bindParam(':transactionId', $transactionId, PDO::PARAM_STR);
        
        return $stmt->execute();
    } catch (\PDOException $e) {
        // Log error
        error_log("Error storing payment: " . $e->getMessage());
        return false;
    }
}

    /**
     * Get payment history for a student
     * 
     * @param int $studentId The student ID
     * @return array Payment history
     */
    public function getPaymentHistory($studentId) {
        try {
            $sql = "SELECT * FROM student_point_purchase WHERE student_id = :studentId ORDER BY payment_id DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Log error
            error_log("Error retrieving payment history: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a specific payment by ID
     * 
     * @param int $paymentId The payment ID
     * @return array|bool Payment details or false if not found
     */
    public function getPaymentById($paymentId) {
        try {
            $sql = "SELECT * FROM student_point_purchase WHERE payment_id = :paymentId";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':paymentId', $paymentId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Log error
            error_log("Error retrieving payment details: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Calculate points based on payment amount
     * 
     * @param int $amount The payment amount
     * @return int The number of points
     */
    public function calculatePoints($amount) {
        // Assuming 1 point = 10 currency units
        return intval($amount / 10);
    }
}