<?php

namespace App\Models;

use PDO;

class SubjectPageModel {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'eguru_full';
        $username = 'root';
        $password = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Database Connection Error: " . $e->getMessage());
            throw new \Exception("Database connection failed");
        }
    }

    public function getTutorsBySubject($subject, $gradeFilter = '', $availableOnly = false) {
        try {
            $sql = "SELECT 
                        tutor_id, 
                        name, 
                        subject, 
                        tutor_level, 
                        availability, 
                        profile_image,
                        hour_fees,
                        rating,
                        grade 
                    FROM tutor_new 
                    WHERE subject = :subject";
            
            if ($gradeFilter !== '') {
                $sql .= " AND tutor_level = :tutor_level";
            }
            
            if ($availableOnly) {
                $sql .= " AND availability = 'Available'";
            }
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
            
            if ($gradeFilter !== '') {
                $stmt->bindParam(':tutor_level', $gradeFilter, PDO::PARAM_STR);
            }
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error fetching tutors");
        }
    }

    public function getTutorLevelsBySubject($subject) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT DISTINCT tutor_level 
                FROM tutor_new 
                WHERE subject = :subject 
                ORDER BY tutor_level
            ");
            $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch(PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error fetching tutor levels");
        }
    }
}