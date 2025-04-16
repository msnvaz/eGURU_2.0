<?php

namespace App\Models;

use PDO;

class SubjectPageModel {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'eguru';
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
            $sql = "
                SELECT 
                    t.tutor_id,
                    t.tutor_first_name,
                    t.tutor_last_name,
                    t.tutor_profile_photo,
                    s.subject_name,
                    tl.tutor_level,
                    tl.tutor_pay_per_hour,
                    AVG(sf.session_rating) AS avg_rating,
                    GROUP_CONCAT(
                        CONCAT(ta.day, ' ', ts.starting_time, '-', ts.ending_time)
                        ORDER BY ta.day, ts.starting_time
                        SEPARATOR ', '
                    ) AS availability_slots
                FROM tutor t
                INNER JOIN tutor_subject tj ON t.tutor_id = tj.tutor_id
                INNER JOIN subject s ON tj.subject_id = s.subject_id
                INNER JOIN tutor_level tl ON t.tutor_level_id = tl.tutor_level_id
                LEFT JOIN session se ON t.tutor_id = se.tutor_id
                LEFT JOIN session_feedback sf ON se.session_id = sf.session_id
                LEFT JOIN tutor_availability ta ON t.tutor_id = ta.tutor_id
                LEFT JOIN time_slot ts ON ta.time_slot_id = ts.time_slot_id
                WHERE s.subject_name = :subject
            ";

            if ($gradeFilter !== '') {
                $sql .= " AND tl.tutor_level = :tutor_level";
            }

            if ($availableOnly) {
                $sql .= " AND ta.tutor_id IS NOT NULL";
            }

            $sql .= "
                GROUP BY 
                    t.tutor_id, 
                    t.tutor_first_name, 
                    t.tutor_last_name, 
                    t.tutor_profile_photo, 
                    s.subject_name,
                    tl.tutor_level,
                    tl.tutor_pay_per_hour
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);

            if ($gradeFilter !== '') {
                $stmt->bindParam(':tutor_level', $gradeFilter, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error fetching tutors");
        }
    }

    public function getTutorLevelsBySubject($subject) {
        try {
            $sql = "
                SELECT DISTINCT 
                    tl.tutor_level,
                    tl.tutor_pay_per_hour
                FROM tutor t
                INNER JOIN tutor_level tl ON t.tutor_level_id = tl.tutor_level_id
                INNER JOIN tutor_subject ts ON t.tutor_id = ts.tutor_id
                INNER JOIN subject s ON ts.subject_id = s.subject_id
                WHERE s.subject_name = :subject
                ORDER BY tl.tutor_level
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Database Query Error: " . $e->getMessage());
            throw new \Exception("Error fetching tutor levels");
        }
    }
}
