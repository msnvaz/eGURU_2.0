<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;
use Exception;

class AdminSubjectModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    public function getSubjectName($subject_id) {
        $query = "SELECT subject_name FROM subject WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getRecentSubjects() {
        try {
            $sql = "SELECT subject_id, subject_name, subject_display_pic 
                    FROM subject 
                    WHERE subject_status = 'set'
                    ORDER BY subject_id DESC 
                    LIMIT 5";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error fetching recent subjects: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllSubjects() {
        $sql = "SELECT * FROM subject ORDER BY subject_id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubjectById($subject_id) {
        $sql = "SELECT * FROM subject WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function subjectExists($subject_name) {
        $sql = "SELECT COUNT(*) FROM subject WHERE subject_name = :subject_name";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':subject_name', $subject_name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function updateSubject($data) {
        try {
            if (!isset($data['subject_name'], $data['subject_id'])) {
                throw new Exception("Missing required subject information");
            }

            $query = "UPDATE subject SET subject_name = :subject_name";
            $params = [
                ':subject_name' => $data['subject_name'],
                ':subject_id' => $data['subject_id']
            ];
            
            if (isset($data['subject_display_pic'])) {
                $query .= ", subject_display_pic = :subject_display_pic";
                $params[':subject_display_pic'] = $data['subject_display_pic'];
            }
            
            $query .= " WHERE subject_id = :subject_id";
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch (Exception $e) {
            error_log("Subject Update Error: " . $e->getMessage());
            return false;
        }
    }

    public function insertSubject($data) {
        try {
            $this->conn->beginTransaction();
            $query = "INSERT INTO subject (subject_name, subject_display_pic, subject_status) 
                      VALUES (:subject_name, :subject_display_pic, 'set')";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':subject_name' => $data['subject_name'],
                ':subject_display_pic' => $data['subject_display_pic']
            ]);
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error inserting subject: " . $e->getMessage());
            return false;
        }
    }

    public function unsetSubject($subjectId) {
        return $this->setSubjectStatus($subjectId, 'unset');
    }
    
    public function setSubject($subjectId) {
        return $this->setSubjectStatus($subjectId, 'set');
    }

    public function getUnsetSubjects() {
        $sql = "SELECT * FROM subject WHERE subject_status = 'unset' ORDER BY subject_id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setSubjectStatus($subjectId, $status) {
        $query = "UPDATE subject SET subject_status = :status WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}