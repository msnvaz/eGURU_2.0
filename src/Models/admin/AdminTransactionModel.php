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
        // SQL query to join session_payments, sessions, students, and tutors
        //only completed sessions
        $query = "SELECT 
                    sp.payment_id, 
                    sp.payment_point_amount, 
                    sp.payment_time, 
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
    

    public function refund($id) {
        //check if tutor has enough points to refund
        $query = "SELECT points_paid,tutor_id FROM session_payments WHERE payment_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $points = $stmt->fetch(PDO::FETCH_ASSOC);

        $query = "SELECT points FROM tutors WHERE tutor_id = :id";
        $stmt = $this->conn->prepare($query);
        $query = "UPDATE session_payments SET status = 'refunded' WHERE payment_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function searchPayments($searchTerm) {
        $query = "SELECT 
                    sp.payment_id, 
                    sp.payment_point_amount, 
                    sp.payment_time, 
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

}
