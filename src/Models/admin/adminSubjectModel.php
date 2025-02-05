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
        $query = "SELECT subject_name FROM subjects WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Fetch recent subjects
    public function getRecentSubjects() {
        try {
            $sql = "SELECT subject_id, subject_name, display_pic, grade_6, grade_7, grade_8, grade_9, grade_10, grade_11 
                    FROM subjects 
                    ORDER BY subject_id DESC 
                    LIMIT 5";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log the error
            error_log('Error fetching recent subjects: ' . $e->getMessage());
            return []; // Return an empty array instead of throwing an exception
        }
    }

    //get all subjects
    public function getAllSubjects() {
        $sql = "SELECT * FROM subjects ORDER BY subject_id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns an array of subjects
    }
    

    //get subject by subject id
    public function getSubjectById($subject_id) {
        $sql = "SELECT * FROM subjects WHERE subject_id = ?";
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

            // Prepare the base query with all possible grade columns
            $query = "UPDATE subjects 
                    SET subject_name = :subject_name,
                        grade_6 = :grade_6,
                        grade_7 = :grade_7,
                        grade_8 = :grade_8,
                        grade_9 = :grade_9,
                        grade_10 = :grade_10,
                        grade_11 = :grade_11";

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

            // Explicitly set grade values (boolean)
            $stmt->bindValue(':grade_6', in_array(6, $data['grades']) ? true : false, PDO::PARAM_BOOL);
            $stmt->bindValue(':grade_7', in_array(7, $data['grades']) ? true : false, PDO::PARAM_BOOL);
            $stmt->bindValue(':grade_8', in_array(8, $data['grades']) ? true : false, PDO::PARAM_BOOL);
            $stmt->bindValue(':grade_9', in_array(9, $data['grades']) ? true : false, PDO::PARAM_BOOL);
            $stmt->bindValue(':grade_10', in_array(10, $data['grades']) ? true : false, PDO::PARAM_BOOL);
            $stmt->bindValue(':grade_11', in_array(11, $data['grades']) ? true : false, PDO::PARAM_BOOL);

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
        $sql = "SELECT COUNT(*) FROM subjects WHERE subject_name = ?";
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
        $grades = $data['grades'];

        try {
            // Start transaction
            $this->conn->beginTransaction();

            // Insert subject data
            $query = "INSERT INTO subjects (subject_name, display_pic, grade_6, grade_7, grade_8, grade_9, grade_10, grade_11) 
                      VALUES (:subject_name, :display_pic, :grade_6, :grade_7, :grade_8, :grade_9, :grade_10, :grade_11)";
            $stmt = $this->conn->prepare($query);

            // Prepare grade flags
            $gradeFlags = [
                'grade_6' => in_array(6, $grades) ? 1 : 0,
                'grade_7' => in_array(7, $grades) ? 1 : 0,
                'grade_8' => in_array(8, $grades) ? 1 : 0,
                'grade_9' => in_array(9, $grades) ? 1 : 0,
                'grade_10' => in_array(10, $grades) ? 1 : 0,
                'grade_11' => in_array(11, $grades) ? 1 : 0,
            ];

            // Execute query
            $stmt->execute([
                ':subject_name' => $subjectName,
                ':display_pic' => $displayPic,
                ':grade_6' => $gradeFlags['grade_6'],
                ':grade_7' => $gradeFlags['grade_7'],
                ':grade_8' => $gradeFlags['grade_8'],
                ':grade_9' => $gradeFlags['grade_9'],
                ':grade_10' => $gradeFlags['grade_10'],
                ':grade_11' => $gradeFlags['grade_11'],
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
        $query = "UPDATE subjects SET status = 'unset' WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function setSubject($subjectId) {
        $query = "UPDATE subjects SET status = 'set' WHERE subject_id = :subject_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':subject_id', $subjectId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}