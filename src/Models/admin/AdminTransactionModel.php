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
                    sp.points_paid, 
                    sp.time_paid, 
                    s.session_id, 
                    s.scheduled_date, 
                    s.status, 
                    st.name AS student_name, 
                    t.first_name AS tutor_name 

                  FROM session_payments sp 
                  JOIN sessions s ON sp.session_id = s.session_id
                  JOIN students st ON s.student_id = st.student_id
                  JOIN tutors t ON s.tutor_id = t.tutor_id WHERE s.status = 'completed'
                  ORDER BY sp.time_paid DESC"; // Sort by most recent payments
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    //refunding a transaction
    //get id from url
    
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
    // Additional methods for updating and deleting transactions can be added here
}
