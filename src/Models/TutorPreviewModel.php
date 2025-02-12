<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class TutorPreviewModel {
    private $db;

    public function __construct() {
        $database = new Database(); // Instantiate Database class
        $this->db = $database->connect(); // Store the PDO connection in $this->db
    }

    /**
     * Get a tutor's details by ID
     */
    public function getTutorById($tutor_id) {
        try {
            $query = "SELECT tutor_id, name, subject, qualification, availability 
                      FROM tutor_new 
                      WHERE tutor_id = ?";
            
            $stmt = $this->db->prepare($query); // Prepare statement
            $stmt->execute([$tutor_id]); // Pass ID as parameter
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch result as an associative array
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage()); // Log error
            return null; // Return null in case of an error
        }
    }

    /**
     * Get tutors by subject category
     */
    public function getTutorsBySubject($subject) {
        try {
            $query = "SELECT tutor_id, name, subject, qualification, availability 
                      FROM tutor_new 
                      WHERE subject = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([$subject]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}
    