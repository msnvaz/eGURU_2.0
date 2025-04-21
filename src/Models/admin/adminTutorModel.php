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

    public function getPendingTutors() {
        try {
            $query = "SELECT * FROM tutor WHERE tutor_status = 'requested' ORDER BY tutor_registration_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching pending tutors: ' . $e->getMessage());
            return [];
        }
    }
    
    public function approveTutorRequest($tutorId) {
        $query = "UPDATE tutor SET tutor_status = 'set' WHERE tutor_id = :tutorId AND tutor_status = 'requested'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        return $stmt->execute() && $stmt->rowCount() > 0;
    }
    
    public function rejectTutorRequest($tutorId) {
        $query = "UPDATE tutor SET tutor_status = 'unset' WHERE tutor_id = :tutorId AND tutor_status = 'requested'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':tutorId', $tutorId, PDO::PARAM_INT);
        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    public function getTutorUpgradeRequests($status = 'pending') {
        try {
            $query = "SELECT u.*, t.tutor_first_name, t.tutor_last_name, t.tutor_email, t.tutor_profile_photo, 
                    t.tutor_level_id as current_level_id 
                    FROM tutor_level_upgrade u
                    JOIN tutor t ON u.tutor_id = t.tutor_id
                    WHERE u.status = :status
                    ORDER BY u.request_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([':status' => $status]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching tutor upgrade requests: ' . $e->getMessage());
            return [];
        }
    }

    public function searchTutorUpgradeRequests($searchTerm = '', $level = '', $startDate = '', $endDate = '', $status = 'pending') {
        try {
            $query = "SELECT u.*, t.tutor_first_name, t.tutor_last_name, t.tutor_email, t.tutor_profile_photo, 
                    t.tutor_level_id as current_level_id 
                    FROM tutor_level_upgrade u
                    JOIN tutor t ON u.tutor_id = t.tutor_id
                    WHERE u.status = :status";
            $params = [':status' => $status];
            
            if (!empty($searchTerm)) {
                $query .= " AND (t.tutor_first_name LIKE :searchTerm 
                        OR t.tutor_last_name LIKE :searchTerm 
                        OR t.tutor_email LIKE :searchTerm 
                        OR CAST(t.tutor_id AS CHAR) LIKE :searchTerm)";
                $params[':searchTerm'] = "%$searchTerm%";
            }
            
            if (!empty($level)) {
                $query .= " AND u.requested_level_id = :level";
                $params[':level'] = $level;
            }
            
            if (!empty($startDate)) {
                $query .= " AND u.request_date >= :startDate";
                $params[':startDate'] = $startDate;
            }
            
            if (!empty($endDate)) {
                $query .= " AND u.request_date <= :endDate";
                $params[':endDate'] = $endDate;
            }
            
            $query .= " ORDER BY u.request_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error searching tutor upgrade requests: ' . $e->getMessage());
            return [];
        }
    }

    public function getTutorUpgradeRequest($requestId) {
        try {
            $query = "SELECT u.*, t.tutor_first_name, t.tutor_last_name, t.tutor_email, t.tutor_profile_photo, 
                    t.tutor_level_id as current_level_id 
                    FROM tutor_level_upgrade u
                    JOIN tutor t ON u.tutor_id = t.tutor_id
                    WHERE u.request_id = :requestId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':requestId', $requestId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching tutor upgrade request: ' . $e->getMessage());
            return null;
        }
    }

    public function approveUpgradeRequest($requestId, $newLevel = null) {
        try {
            $this->conn->beginTransaction();
            
            // First, get the request details
            $request = $this->getTutorUpgradeRequest($requestId);
            if (!$request) {
                $this->conn->rollBack();
                return false;
            }
            
            // Update the level in the tutor table
            $levelToApply = $newLevel ?? $request['requested_level_id'];
            $tutorUpdateQuery = "UPDATE tutor SET tutor_level_id = :level_id WHERE tutor_id = :tutor_id";
            $tutorStmt = $this->conn->prepare($tutorUpdateQuery);
            $tutorStmt->bindValue(':level_id', $levelToApply, PDO::PARAM_STR);
            $tutorStmt->bindValue(':tutor_id', $request['tutor_id'], PDO::PARAM_INT);
            $tutorStmt->execute();
            
            // Update the request status
            $requestUpdateQuery = "UPDATE tutor_level_upgrade SET status = 'accepted', status_updated_date = CURDATE() WHERE request_id = :request_id";
            $requestStmt = $this->conn->prepare($requestUpdateQuery);
            $requestStmt->bindValue(':request_id', $requestId, PDO::PARAM_INT);
            $requestStmt->execute();
            
            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log('Error approving tutor upgrade request: ' . $e->getMessage());
            return false;
        }
    }

    public function rejectUpgradeRequest($requestId) {
        try {
            $query = "UPDATE tutor_level_upgrade SET status = 'rejected', status_updated_date = CURDATE() WHERE request_id = :request_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':request_id', $requestId, PDO::PARAM_INT);
            return $stmt->execute() && $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error rejecting tutor upgrade request: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllTutorLevels() {
        try {
            $query = "SELECT * FROM tutor_level ORDER BY tutor_level_id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching tutor levels: ' . $e->getMessage());
            return [];
        }
    }
}