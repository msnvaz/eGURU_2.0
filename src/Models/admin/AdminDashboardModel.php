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
    
    public function getTotalStudentPoints(){
        $query = "SELECT SUM(student_points) as total_points FROM student";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total_points'] ?? 0; // Return the value or 0 if null
    }

    public function getTotalTutorpoints(){
        $query = "SELECT SUM(tutor_points) as total_points FROM tutor";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['total_points'] ?? 0; // Return the value or 0 if null
    }

    public function getPointValue() {
        $query = "SELECT admin_setting_value FROM admin_settings WHERE admin_setting_name = 'point_value'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (float)$result['admin_setting_value']:0; // Return 0 if result is null
    }

    public function getPlatformFee() {
        $query = "SELECT admin_setting_value FROM admin_settings WHERE admin_setting_name = 'platform_fee'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (float)$result['admin_setting_value'] : 0; // or (int) if always integer
    }
    
    
    public function getSessionFeedbackRatings() {
        $ratings = [0, 0, 0, 0, 0]; // Initialize array for 1-5 star ratings
        
        $query = "SELECT session_rating, COUNT(*) as count 
                  FROM session_feedback 
                  WHERE session_rating IS NOT NULL 
                  GROUP BY session_rating 
                  ORDER BY session_rating";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as $result) {
            if ($result['session_rating'] >= 1 && $result['session_rating'] <= 5) {
                $ratings[$result['session_rating'] - 1] = (int)$result['count'];
            }
        }
        
        return $ratings;
    }

    public function getAverageSessionRating() {
        $query = "SELECT AVG(session_rating) as average_rating FROM session_feedback WHERE session_rating IS NOT NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // If no feedback data exists, return default value
        if (!$result || !$result['average_rating']) {
            return 4.2; // Default average rating
        }
        
        return (float)$result['average_rating'];
    }
    
    /*public function getAverageRatingsByCategory() {
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
    }*/
}