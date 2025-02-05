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
        $query = "SELECT * FROM tutor_grading";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    // Update a grade with duplicate check 
    public function updateGrade($grade_id, $grade, $qualification, $pay_per_hour) {
        // Check if the grade name already exists
        $query = "SELECT COUNT(*) FROM tutor_grading WHERE grade = :grade AND grade_id != :grade_id"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':grade', $grade); 
        $stmt->bindParam(':grade_id', $grade_id); 
        $stmt->execute(); 
        $isDuplicate = $stmt->fetchColumn() > 0; 
        if ($isDuplicate) { echo "
            <script>
                alert('Grade name already exists');
                window.location.href='/admin-tutor-grading';"; 
            return false; } // Proceed with the update if no duplicates found
        $query = "UPDATE tutor_grading SET grade = :grade, qualification = :qualification, pay_per_hour = :pay_per_hour WHERE grade_id = :grade_id"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':grade_id', $grade_id); 
        $stmt->bindParam(':grade', $grade); 
        $stmt->bindParam(':qualification', $qualification); 
        $stmt->bindParam(':pay_per_hour', $pay_per_hour); 
        $stmt->execute(); 
        return true;
    }
}