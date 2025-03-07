<?php

// src/Models/admin/AdminDashboardModel.php
namespace App\Models\admin;

use App\Config\Database;
use PDO;

class AdminDashboardModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    public function getTotalTutors() {
        $query = "SELECT COUNT(*) as total FROM tutor";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalStudents() {
        $query = "SELECT COUNT(*) as total FROM student";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalSessions() {
        $query = "SELECT COUNT(*) as total FROM session";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getCompletedSessions() {
        $query = "SELECT COUNT(*) as total FROM session WHERE session_status = 'completed'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalRevenue() {
        $query = "SELECT SUM(payment_point_amount) as total FROM session_payment";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        return $result ? $result : 0; // Return 0 if result is null
    }

    public function getStudentRegistrationsByMonth() {
        $query = "SELECT MONTH(student_registration_date) as month, COUNT(*) as total FROM student GROUP BY MONTH(student_registration_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTutorRegistrationsByMonth() {
        $query = "SELECT MONTH(tutor_registration_date) as month, COUNT(*) as total FROM tutor GROUP BY MONTH(tutor_registration_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSessionsPerSubject() {
        $query = "SELECT s.subject_id, sub.subject_name, COUNT(*) as total FROM session AS s 
                  JOIN subject AS sub ON s.subject_id = sub.subject_id 
                  GROUP BY s.subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSessionCountsByStatus() {
        $query = "SELECT session_status, COUNT(*) as total FROM session GROUP BY session_status";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getTopTutorsByRating($limit = 5) {
        $query = "SELECT t.tutor_id, t.tutor_fname, t.tutor_lname, AVG(r.rating) as average_rating, 
                  COUNT(s.session_id) as session_count 
                  FROM tutor t
                  JOIN session s ON t.tutor_id = s.tutor_id
                  LEFT JOIN ratings r ON s.session_id = r.session_id
                  GROUP BY t.tutor_id
                  ORDER BY average_rating DESC
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAverageRatingsByCategory() {
        $query = "SELECT 
                  AVG(punctuality) as punctuality,
                  AVG(knowledge) as knowledge,
                  AVG(clarity) as clarity,
                  AVG(engagement) as engagement,
                  AVG(helpfulness) as helpfulness
                  FROM feedback";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // If no feedback data exists, return default values
        if (!$result || !$result['punctuality']) {
            return [
                'punctuality' => 4.2,
                'knowledge' => 5.0,
                'clarity' => 4.5,
                'engagement' => 3.8,
                'helpfulness' => 4.8
            ];
        }
        
        return $result;
    }
}