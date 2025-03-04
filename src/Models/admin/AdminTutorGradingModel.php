<?php
namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class adminTutorGradingModel {
    private $conn;

    public function __construct() {
        // Initialize the Database class and get the connection
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    // Fetch    
    public function getAllGrades(){
        $query = "SELECT * FROM tutor_level";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Update a tutor_level with duplicate check 
    public function updateGrade($tutor_level_id, $tutor_level, $tutor_level_qualification, $tutor_pay_per_hour) {
        // Check if the tutor_level name already exists
        $query = "SELECT COUNT(*) FROM tutor_level WHERE tutor_level = :tutor_level AND tutor_level_id != :tutor_level_id"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':tutor_level', $tutor_level); 
        $stmt->bindParam(':tutor_level_id', $tutor_level_id); 
        $stmt->execute(); 
        $isDuplicate = $stmt->fetchColumn() > 0; 
        if ($isDuplicate) { echo "
            <script>
                alert('Grade name already exists');
                window.location.href='/admin-tutor-grading';"; 
            return false; } // Proceed with the update if no duplicates found
        $query = "UPDATE tutor_level SET tutor_level = :tutor_level, tutor_level_qualification = :tutor_level_qualification, tutor_pay_per_hour = :tutor_pay_per_hour WHERE tutor_level_id = :tutor_level_id"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':tutor_level_id', $tutor_level_id); 
        $stmt->bindParam(':tutor_level', $tutor_level); 
        $stmt->bindParam(':tutor_level_qualification', $tutor_level_qualification); 
        $stmt->bindParam(':tutor_pay_per_hour', $tutor_pay_per_hour); 
        $stmt->execute(); 
        return true;
    }
}