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
        
        error_log("Error storing payment: " . $e->getMessage());
        return false;
    }
}

    public function updateStudentPoints($studentId, $points) {
        try {
            $sql = "UPDATE student SET student_points = student_points + :points WHERE student_id = :studentId";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':points', $points, PDO::PARAM_INT);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            
            error_log("Error updating student points: " . $e->getMessage());
            return false;
        }
    }
    
    public function getPaymentHistory($studentId) {
        try {
            $sql = "SELECT * FROM student_point_purchase WHERE student_id = :studentId ORDER BY payment_id DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            
            error_log("Error retrieving payment history: " . $e->getMessage());
            return [];
        }
    }

    
    public function getPaymentById($paymentId) {
        try {
            $sql = "SELECT * FROM student_point_purchase WHERE payment_id = :paymentId";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':paymentId', $paymentId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            
            error_log("Error retrieving payment details: " . $e->getMessage());
            return false;
        }
    }

    
    public function calculatePoints($amount) {
        
        return intval($amount / 10);
    }
}