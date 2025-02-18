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
        $query = "SELECT * FROM student WHERE status = 'set'"; ;

        // Check if search is performed
        if (isset($_POST['search'])) {
            $searchTerm = $_POST['search_term'];
            //added id search too
            $query = "SELECT * FROM student WHERE firstname LIKE :searchTerm OR lastname LIKE :searchTerm OR email LIKE :searchTerm OR id LIKE :searchTerm";
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
        $query = "SELECT * FROM student WHERE id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Update student profile
    // Check if email already exists (excluding current student)
    public function emailExists($email, $studentId) {
        $query = "SELECT COUNT(*) FROM student WHERE email = :email AND id != :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updateStudentProfile($studentId, $data) {
        // Initialize the query

        $query = "UPDATE student SET ";
        $params = [];
        
        // Build the SET clause dynamically
        foreach ($data as $field => $value) {
            $query .= "$field = :$field, ";
            $params[":$field"] = $value;
        }
        
        // Remove trailing comma and space
        $query = rtrim($query, ', ');
        
        // Add WHERE clause
        $query .= " WHERE id = :id";
        $params[':id'] = $studentId;
        
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
        $query = "UPDATE student SET status = 'unset' WHERE id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; // Ensure at least one row was updated
        }
        return false;
    }

    // Get all deleted students
    public function getDeletedStudents() {
        $query = "SELECT * FROM student WHERE status = 'unset'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Restore student profile
    public function restoreStudentProfile($studentId) {
        $query = "UPDATE student SET status = 'set' WHERE id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; // Ensure at least one row was updated
        }
        return false;
    }

    
}
