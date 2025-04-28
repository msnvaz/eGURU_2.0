<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;

class AdminTransactionModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->Connect();
    }

    public function getAllPayments() {
        $query = "SELECT 
                    sp.payment_id, 
                    sp.payment_point_amount, 
                    sp.payment_time, 
                    sp.payment_status,
                    s.session_id, 
                    s.scheduled_date, 
                    s.session_status, 
                    st.student_first_name,
                    st.student_last_name,
                    st.student_email,
                    st.student_id,
                    t.tutor_first_name,
                    t.tutor_last_name,
                    t.tutor_email,
                    t.tutor_id
                  FROM session_payment sp 
                  JOIN session s ON sp.session_id = s.session_id
                  JOIN student st ON s.student_id = st.student_id
                  JOIN tutor t ON s.tutor_id = t.tutor_id 
                  WHERE s.session_status = 'completed' 
                  ORDER BY sp.payment_time DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function searchPayments($searchTerm) {
        $query = "SELECT 
                    sp.payment_id, 
                    sp.payment_point_amount, 
                    sp.payment_time, 
                    sp.payment_status,
                    s.session_id, 
                    s.scheduled_date, 
                    s.session_status, 
                    st.student_first_name,
                    st.student_last_name,
                    st.student_email,
                    st.student_id,
                    t.tutor_first_name,
                    t.tutor_last_name,
                    t.tutor_email,
                    t.tutor_id
                  FROM session_payment sp 
                  JOIN session s ON sp.session_id = s.session_id
                  JOIN student st ON s.student_id = st.student_id
                  JOIN tutor t ON s.tutor_id = t.tutor_id 
                  WHERE s.session_status = 'completed' 
                  AND (sp.payment_id LIKE :searchTerm 
                  OR st.student_first_name LIKE :searchTerm 
                  OR st.student_last_name LIKE :searchTerm
                  OR st.student_email LIKE :searchTerm
                  OR st.student_id LIKE :searchTerm
                  OR t.tutor_first_name LIKE :searchTerm
                  OR t.tutor_last_name LIKE :searchTerm
                  OR t.tutor_email LIKE :searchTerm)
                  ORDER BY sp.payment_time DESC";
    
        $stmt = $this->conn->prepare($query);
        $searchTerm = "%{$searchTerm}%"; // Prepare search term for LIKE query
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTransactionStatus($paymentId, $status) {
        $query = "SELECT sp.payment_id, sp.payment_point_amount, sp.payment_status, sp.student_id, sp.tutor_id 
                  FROM session_payment sp 
                  WHERE sp.payment_id = :paymentId";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':paymentId', $paymentId);
        $stmt->execute();
        
        $payment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($payment['payment_status'] === 'refunded') {
            return false;
        }
        
        $tutorQuery = "SELECT tutor_points FROM tutor WHERE tutor_id = :tutorId";
        $stmt = $this->conn->prepare($tutorQuery);
        $stmt->bindParam(':tutorId', $payment['tutor_id']);
        $stmt->execute();
        
        $tutor = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($tutor['tutor_points'] < $payment['payment_point_amount']) {
            return false;
        }
        
        $this->conn->beginTransaction();
        
        try {
            $updatePaymentQuery = "UPDATE session_payment SET payment_status = :status WHERE payment_id = :paymentId";
            $stmt = $this->conn->prepare($updatePaymentQuery);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':paymentId', $paymentId);
            $stmt->execute();
            
            $deductPointsQuery = "UPDATE tutor SET tutor_points = tutor_points - :points WHERE tutor_id = :tutorId";
            $stmt = $this->conn->prepare($deductPointsQuery);
            $stmt->bindParam(':points', $payment['payment_point_amount']);
            $stmt->bindParam(':tutorId', $payment['tutor_id']);
            $stmt->execute();
            
            $addPointsQuery = "UPDATE student SET student_points = student_points + :points WHERE student_id = :studentId";
            $stmt = $this->conn->prepare($addPointsQuery);
            $stmt->bindParam(':points', $payment['payment_point_amount']);
            $stmt->bindParam(':studentId', $payment['student_id']);
            $stmt->execute();
            
            $this->conn->commit();
            
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }
}