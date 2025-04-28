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

    public function getAllStudents($status = 'set') {
        try {
            $query = "SELECT * FROM student WHERE student_status = :status";
            $params = [':status' => $status];
            
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching students: ' . $e->getMessage());
            return [];
        }
    }

    public function searchStudents($searchTerm = '', $grade = '', $registrationStartDate = '', $registrationEndDate = '', $status = 'set', $onlineStatus = '') {
        try {
            $query = "SELECT * FROM student WHERE student_status = :status";
            $params = [':status' => $status];
            
            if (!empty($searchTerm)) {
                $query .= " AND (student_first_name LIKE :searchTerm 
                          OR student_last_name LIKE :searchTerm 
                          OR student_email LIKE :searchTerm 
                          OR CAST(student_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
            
            if (!empty($grade)) {
                $query .= " AND student_grade = :grade";
                $params[':grade'] = $grade;
            }
            
            if (!empty($registrationStartDate)) {
                $query .= " AND student_registration_date >= :startDate";
                $params[':startDate'] = $registrationStartDate;
            }
            
            if (!empty($registrationEndDate)) {
                $query .= " AND student_registration_date <= :endDate";
                $params[':endDate'] = $registrationEndDate;
            }
            
            if (!empty($onlineStatus)) {
                $query .= " AND student_log = :onlineStatus";
                $params[':onlineStatus'] = $onlineStatus;
            }
            
            $query .= " ORDER BY student_id DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error searching students: ' . $e->getMessage());
            return [];
        }
    }

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
    
    public function getStudentProfile($studentId) {
        $query = "SELECT * FROM student WHERE student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function emailExists($student_email, $studentId) {
        $query = "SELECT COUNT(*) FROM student WHERE student_email = :student_email AND student_id != :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':student_email', $student_email, PDO::PARAM_STR);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updateStudentProfile($studentId, $data, $file = null) {
        if (empty($data)) {
            error_log("No data provided for update");
            return false;
        }

        $query = "UPDATE student SET ";
        $params = [];
        
        if ($file && isset($file['name']) && !empty($file['name']) && $file['error'] == 0) {
            $targetDir = "uploads/Student_Profiles/";
            
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            
            $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
            $newFileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $targetFilePath = $targetDir . $newFileName;
            
            error_log("Attempting to move uploaded file from: " . $file["tmp_name"] . " to: " . $targetFilePath);
            
            if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
                $data['student_profile_photo'] = $newFileName;
                error_log("File uploaded successfully to: " . $targetFilePath);
            } else {
                error_log("Failed to upload file: " . error_get_last()['message']);
            }
        }

        foreach ($data as $field => $value) {
            $query .= "$field = :$field, ";
            $params[":$field"] = $value;
        }
        
        $query = rtrim($query, ', ');
        
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

    public function deleteStudentProfile($studentId) {
        $query = "UPDATE student SET student_status = 'unset' WHERE student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; // Ensure at least one row was updated
        }
        return false;
    }

    public function getDeletedStudents() {
        return $this->getAllStudents('unset');
    }

    public function getBlockedStudents() {
        return $this->getAllStudents('blocked');
    }

    public function restoreStudentProfile($studentId) {
        $query = "UPDATE student SET student_status = 'set' WHERE student_id = :studentId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':studentId', $studentId, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $stmt->rowCount() > 0; // Ensure at least one row was updated
        }
        return false;
    }

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
