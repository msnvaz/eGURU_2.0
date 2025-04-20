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

    // Fetch all students with filtering options
    public function getAllStudents($status = 'set') {
        try {
            // Default query to fetch students by status
            $query = "SELECT * FROM student WHERE student_status = :status";
            $params = [':status' => $status];
            
            // Execute the query
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching students: ' . $e->getMessage());
            return [];
        }
    }

    // Search students by term and apply filters
    public function searchStudents($searchTerm = '', $grade = '', $registrationStartDate = '', $registrationEndDate = '', $status = 'set', $onlineStatus = '') {
        try {
            $query = "SELECT * FROM student WHERE student_status = :status";
            $params = [':status' => $status];
            
            // Add search term filter
            if (!empty($searchTerm)) {
                $query .= " AND (student_first_name LIKE :searchTerm 
                          OR student_last_name LIKE :searchTerm 
                          OR student_email LIKE :searchTerm 
                          OR CAST(student_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
            
            // Add grade filter
            if (!empty($grade)) {
                $query .= " AND student_grade = :grade";
                $params[':grade'] = $grade;
            }
            
            // Add registration date range filter
            if (!empty($registrationStartDate)) {
                $query .= " AND student_registration_date >= :startDate";
                $params[':startDate'] = $registrationStartDate;
            }
            
            if (!empty($registrationEndDate)) {
                $query .= " AND student_registration_date <= :endDate";
                $params[':endDate'] = $registrationEndDate;
            }
            
            // Add online status filter
            if (!empty($onlineStatus)) {
                $query .= " AND student_log = :onlineStatus";
                $params[':onlineStatus'] = $onlineStatus;
            }
            
            // Order by id for consistency
            $query .= " ORDER BY student_id DESC";
            
            // Execute the query
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error searching students: ' . $e->getMessage());
            return [];
        }
    }

    // Get distinct student grades for the dropdown filter
    public function getStudentGrades() {
        try {
            $query = "SELECT DISTINCT student_grade FROM student 
                     WHERE student_grade IS NOT NULL 
                     ORDER BY student_grade";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching student grades: ' . $e->getMessage());
            return [];
        }
    }

    // The rest of your existing methods...
    
    public function getStudentProfile($studentId) {
        $query = "SELECT * FROM student WHERE student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    // Check if student_email already exists (excluding current student)
    public function emailExists($student_email, $studentId) {
        $query = "SELECT COUNT(*) FROM student WHERE student_email = :student_email AND student_id != :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':student_email', $student_email, PDO::PARAM_STR);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updateStudentProfile($studentId, $data, $file = null) {
        // Ensure that the data array is not empty
        if (empty($data)) {
            error_log("No data provided for update");
            return false;
        }

        // Initialize the query
        $query = "UPDATE student SET ";
        $params = [];
        
        // Handle file upload for profile photo
        if ($file && isset($file['name']) && !empty($file['name']) && $file['error'] == 0) {
            // Use the correct path to match where AdminStudentProfileEdit.php is looking
            $targetDir = "uploads/Student_Profiles/";
            
            // Ensure directory exists
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            // Generate a unique filename to avoid overwriting existing files
            $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
            $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $targetFilePath = $targetDir . $newFileName;
            
            // Debug the file upload
            error_log("Attempting to move uploaded file from: " . $file["tmp_name"] . " to: " . $targetFilePath);
            
            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                // Only store the filename in the database, not the full path
                $data['student_profile_photo'] = $newFileName;
                error_log("File uploaded successfully to: " . $targetFilePath);
            } else {
                error_log("Failed to upload file: " . error_get_last()['message']);
            }
        }

        // Build the SET clause dynamically
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
        return $this->getAllStudents('unset');
    }

    // Get all blocked students
    public function getBlockedStudents() {
        return $this->getAllStudents('blocked');
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

    // Update student status (e.g., block, unblock)
    public function updateStudentStatus($studentId, $status) {
        $query = "UPDATE student SET student_status = :status WHERE student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        }
        return false;
    }
}
