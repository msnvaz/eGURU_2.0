<?php
namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class adminTutorModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllTutors($status = 'set') {
        try {
            $query = "SELECT * FROM tutor WHERE tutor_status = :status";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':status' => $status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching tutors: ' . $e->getMessage());
            return [];
        }
    }

    public function searchTutors($searchTerm = '', $grade = '', $registrationStartDate = '', $registrationEndDate = '', $status = 'set', $onlineStatus = '') {
        try {
            $query = "SELECT * FROM tutor WHERE tutor_status = :status";
            $params = [':status' => $status];
            
            if (!empty($searchTerm)) {
                $query .= " AND (tutor_first_name LIKE :searchTerm 
                          OR tutor_last_name LIKE :searchTerm 
                          OR tutor_email LIKE :searchTerm 
                          OR CAST(tutor_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
            
            if (!empty($grade)) {
                $query .= " AND tutor_level_id = :grade";
                $params[':grade'] = $grade;
            }
            
            if (!empty($registrationStartDate)) {
                $query .= " AND tutor_registration_date >= :startDate";
                $params[':startDate'] = $registrationStartDate;
            }
            
            if (!empty($registrationEndDate)) {
                $query .= " AND tutor_registration_date <= :endDate";
                $params[':endDate'] = $registrationEndDate;
            }
            
            if (!empty($onlineStatus) && $status != 'blocked' && $status != 'unset') {
                $query .= " AND tutor_log = :onlineStatus";
                $params[':onlineStatus'] = $onlineStatus;
            }
            
            $query .= " ORDER BY tutor_id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error searching tutors: ' . $e->getMessage());
            return [];
        }
    }

    public function getTutorGrades() {
        try {
            $query = "SELECT DISTINCT tutor_level_id FROM tutor 
                     WHERE tutor_level_id IS NOT NULL 
                     ORDER BY tutor_level_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching tutor grades: ' . $e->getMessage());
            return [];
        }
    }

    public function getTutorProfile($tutorId) {
        $query = "SELECT * FROM tutor WHERE tutor_id = :tutorId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExists($tutor_email, $tutorId) {
        $query = "SELECT COUNT(*) FROM tutor WHERE tutor_email = :tutor_email AND tutor_id != :tutorId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutor_email', $tutor_email, PDO::PARAM_STR);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updateTutorProfile($tutorId, $data) {
        if (empty($data)) return false;

        $query = "UPDATE tutor SET ";
        $params = [];
        
        foreach ($data as $field => $value) {
            $query .= "$field = :$field, ";
            $params[":$field"] = $value;
        }
        
        $query = rtrim($query, ', ');
        $query .= " WHERE tutor_id = :tutor_id";
        $params[':tutor_id'] = $tutorId;
        
        try {
            $stmt = $this->conn->prepare($query);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating tutor profile: " . $e->getMessage());
            return false;
        }
    }

    public function deleteTutorProfile($tutorId) {
        $query = "UPDATE tutor SET tutor_status = 'unset' WHERE tutor_id = :tutorId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    public function getDeletedTutors() {
        return $this->getAllTutors('unset');
    }

    public function restoreTutorProfile($tutorId) {
        $query = "UPDATE tutor SET tutor_status = 'set' WHERE tutor_id = :tutorId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    public function blockTutorProfile($tutorId) {
        $query = "UPDATE tutor SET tutor_status = 'blocked' WHERE tutor_id = :tutorId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        return $stmt->execute() && $stmt->rowCount() > 0;
    }
    
    public function unblockTutorProfile($tutorId) {
        $query = "UPDATE tutor SET tutor_status = 'set' WHERE tutor_id = :tutorId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        return $stmt->execute() && $stmt->rowCount() > 0;
    }
    
    public function getBlockedTutors() {
        try {
            $query = "SELECT * FROM tutor WHERE tutor_status = 'blocked'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching blocked tutors: ' . $e->getMessage());
            return [];
        }
    }
}