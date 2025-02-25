<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class adminSubjectModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    //get subject name
    public function getSubjectName($subject_id) {
        $query = "SELECT subject_name FROM subject WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Fetch recent subject
    public function getRecentSubjects() {
        try {
            $sql = "SELECT subject_id, subject_name, display_pic 
                    FROM subject 
                    WHERE subject_status = 'set'
                    ORDER BY subject_id DESC 
                    LIMIT 5";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error
            error_log('Error fetching recent subject: ' . $e->getMessage());
            return []; // Return an empty array instead of throwing an exception
        }
    }

    //get all subject
    public function getAllSubjects() {
        $sql = "SELECT * FROM subject ORDER BY subject_id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns an array of subject
    }
    

    //get subject by subject id
    public function getSubjectById($subject_id) {
        $sql = "SELECT * FROM subject WHERE subject_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $subject_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //update subject
    public function updateSubject($data)
    {
        try {
            // Validate required data
            if (!isset($data['subject_name']) || !isset($data['subject_id'])) {
                throw new Exception("Missing required subject information");
            }

            // Prepare the base query
            $query = "UPDATE subject 
                    SET subject_name = :subject_name";

            // Add display_pic to the update if provided
            if (isset($data['display_pic'])) {
                $query .= ", display_pic = :display_pic";
            }

            // Add WHERE clause
            $query .= " WHERE subject_id = :subject_id";

            // Prepare the statement
            $stmt = $this->conn->prepare($query);

            // Bind subject name and ID
            $stmt->bindParam(':subject_name', $data['subject_name']);
            $stmt->bindParam(':subject_id', $data['subject_id']);

            // Bind display_pic if provided
            if (isset($data['display_pic'])) {
                $stmt->bindParam(':display_pic', $data['display_pic']);
            }

            // Execute the query
            $result = $stmt->execute();

            // Check for execution errors
            if (!$result) {
                $errorInfo = $stmt->errorInfo();
                error_log("Subject Update Failed: " . print_r($errorInfo, true));
                return false;
            }

            return true;
        } catch (Exception $e) {
            error_log("Subject Update Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function subjectExists($subject_name) {
        $sql = "SELECT COUNT(*) FROM subject WHERE subject_name = ?";
        $stmt = $this->conn->prepare($sql);
    
        if ($stmt) {
            $stmt->execute([$subject_name]);
            $count = $stmt->fetchColumn(); // Fetch the count directly
            return $count > 0;
        } else {
            throw new Exception("Failed to prepare SQL statement");
        }
    }
    

    public function insertSubject($data)
    {
        $subjectName = $data['subject_name'];
        $displayPic = $data['display_pic'];

        try {
            // Start transaction
            $this->conn->beginTransaction();

            // Insert subject data
            $query = "INSERT INTO subject (subject_name, display_pic) 
                      VALUES (:subject_name, :display_pic)";
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute([
                ':subject_name' => $subjectName,
                ':display_pic' => $displayPic,
            ]);

            // Commit transaction
            $this->conn->commit();
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->conn->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    public function unsetSubject($subjectId) {
        $query = "UPDATE subject SET subject_status = 'unset' WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function setSubject($subjectId) {
        $query = "UPDATE subject SET subject_status = 'set' WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
