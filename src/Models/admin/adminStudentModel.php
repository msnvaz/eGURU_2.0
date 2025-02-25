<?php
namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class adminStudentModel {
    private $conn;

    public function __construct() {
        // Initialize the Database class and get the connection
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    // Fetch all students
    public function getAllStudents() {
        // Default query to fetch all students
        $query = "SELECT * FROM student WHERE student_status = 'set'"; ;

        // Check if search is performed
        if (isset($_POST['search'])) {
            $searchTerm = $_POST['search_term'];
            //added id search too
            $query = "SELECT * FROM student WHERE student_first_name LIKE :searchTerm OR student_last_name LIKE :searchTerm OR student_email LIKE :searchTerm OR student_id LIKE :searchTerm";
        }

        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind the search term if available
        if (isset($searchTerm)) {
            $stmt->bindValue(':searchTerm', "%$searchTerm%", PDO::PARAM_STR);
        }

        // Execute the query and return the results
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //get student profile on click
    public function getStudentProfile($studentId) {
        $query = "SELECT * FROM student WHERE student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Update student profile
    // Check if student_email already exists (excluding current student)
    public function emailExists($student_email, $studentId) {
        $query = "SELECT COUNT(*) FROM student WHERE student_email = :student_email AND student_id != :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':student_email', $student_email, PDO::PARAM_STR);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updateStudentProfile($studentId, $data) {
        // Ensure that the data array is not empty

        // Initialize the query

        $query = "UPDATE student SET ";
        $params = [];
        
        // Build the SET clause dynamically
        if (empty($data)) {
            error_log("No data provided for update");
            return false;
        }

        foreach ($data as $field => $value) {
            $query .= "$field = :$field, ";
            $params[":$field"] = $value;
        }
        
        // Remove trailing comma and space
        $query = rtrim($query, ', ');
        
        // Add WHERE clause
        $query .= " WHERE student_id = :student_id";
        $params[':student_id'] = $studentId;
        
        try {
            error_log("Executing query: " . $query);
            error_log("With parameters: " . print_r($params, true));
            
            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating student profile: " . $e->getMessage());
            return false;
        }
    }

    //delete student profile
    //update the status to unset
    public function deleteStudentProfile($studentId) {
        $query = "UPDATE student SET student_status = 'unset' WHERE student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; // Ensure at least one row was updated
        }
        return false;
    }

    // Get all deleted students
    public function getDeletedStudents() {
        $query = "SELECT * FROM student WHERE student_status = 'unset'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Restore student profile
    public function restoreStudentProfile($studentId) {
        $query = "UPDATE student SET student_status = 'set' WHERE student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; // Ensure at least one row was updated
        }
        return false;
    }

    
}
