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
        $query = "SELECT COUNT(*) as total FROM tutor"; // Adjust table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalStudents() {
        $query = "SELECT COUNT(*) as total FROM student"; // Adjust table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalTeachers() {
        $query = "SELECT COUNT(*) as total FROM tutor"; // Adjust table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getActiveSessions() {
        $query = "SELECT COUNT(*) as total FROM session WHERE session_status = 'active'"; // Adjust table name and condition as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getRevenue() {
        $query = "SELECT SUM(payment_point_amount) as total FROM session_payment"; // Adjust table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTotalRevenue() {

        $query = "SELECT SUM(payment_point_amount) as total FROM session_payment"; // Adjust table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getStudentRegistrationsByMonth() {
        $query = "SELECT MONTH(student_registration_date) as month, COUNT(*) as total FROM student GROUP BY MONTH(student_registration_date)"; // Adjust table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTutorRegistrationsByMonth() {
        $query = "SELECT MONTH(tutor_registration_date) as month, COUNT(*) as total FROM tutor GROUP BY MONTH(tutor_registration_date)"; // Adjust table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSessions() {


        $query = "SELECT COUNT(*) as total FROM session"; // Adjust table name as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getCompletedSessions() {
        $query = "SELECT COUNT(*) as total FROM session WHERE session_status = 'completed'"; // Adjust table name and condition as necessary
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
?>
