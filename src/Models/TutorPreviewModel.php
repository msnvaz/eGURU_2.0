<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class TutorPreviewModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
    }

    /**
     * Get a tutor's details by ID
     */
    public function getTutorById($tutor_id) {
        try {
            // Step 1: Fetch tutor details and their level qualification
            $query = "SELECT 
                          t.tutor_id,
                          t.tutor_first_name,
                          t.tutor_last_name,
                          t.tutor_profile_photo,
                          l.tutor_level_qualification
                      FROM tutor t
                      JOIN tutor_level l ON t.tutor_level_id = l.tutor_level_id
                      WHERE t.tutor_id = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([$tutor_id]);
            $tutor = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$tutor) {
                return null;
            }

            // Step 2: Fetch all subjects for the tutor
            $subjectQuery = "SELECT s.subject_name
                             FROM tutor_subject ts
                             JOIN subject s ON ts.subject_id = s.subject_id
                             WHERE ts.tutor_id = ?";
            
            $subjectStmt = $this->db->prepare($subjectQuery);
            $subjectStmt->execute([$tutor_id]);
            $subjects = $subjectStmt->fetchAll(PDO::FETCH_COLUMN);
            $tutor['subjects'] = implode(', ', $subjects);

            // Step 3: Fetch availability details
            $availabilityQuery = "SELECT 
                                     ta.day,
                                     ts.starting_time,
                                     ts.ending_time
                                  FROM tutor_availability ta
                                  JOIN time_slot ts ON ta.time_slot_id = ts.time_slot_id
                                  WHERE ta.tutor_id = ?";
            
            $availabilityStmt = $this->db->prepare($availabilityQuery);
            $availabilityStmt->execute([$tutor_id]);
            $availability = $availabilityStmt->fetchAll(PDO::FETCH_ASSOC);

            // Format availability as readable strings
            $formattedAvailability = array_map(function ($slot) {
                return "{$slot['day']} ({$slot['starting_time']} - {$slot['ending_time']})";
            }, $availability);

            $tutor['availability'] = implode(', ', $formattedAvailability);

            return $tutor;

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get tutors by subject name
     */
    public function getTutorsBySubject($subjectName) {
        try {
            // Step 1: Fetch tutors matching the subject
            $query = "SELECT DISTINCT
                          t.tutor_id,
                          t.tutor_first_name,
                          t.tutor_last_name,
                            t.tutor_profile_photo,
                          l.tutor_level_qualification
                      FROM tutor t
                      JOIN tutor_level l ON t.tutor_level_id = l.tutor_level_id
                      JOIN tutor_subject ts ON t.tutor_id = ts.tutor_id
                      JOIN subject s ON ts.subject_id = s.subject_id
                      WHERE s.subject_name = ?";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute([$subjectName]);
            $tutors = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Step 2: For each tutor, fetch subjects and availability
            foreach ($tutors as &$tutor) {
                // Subjects
                $subjectStmt = $this->db->prepare(
                    "SELECT s.subject_name
                     FROM tutor_subject ts
                     JOIN subject s ON ts.subject_id = s.subject_id
                     WHERE ts.tutor_id = ?"
                );
                $subjectStmt->execute([$tutor['tutor_id']]);
                $subjects = $subjectStmt->fetchAll(PDO::FETCH_COLUMN);
                $tutor['subjects'] = implode(', ', $subjects);

                // Availability
                $availabilityStmt = $this->db->prepare(
                    "SELECT 
                        ta.day,
                        ts.starting_time,
                        ts.ending_time
                     FROM tutor_availability ta
                     JOIN time_slot ts ON ta.time_slot_id = ts.time_slot_id
                     WHERE ta.tutor_id = ?"
                );
                $availabilityStmt->execute([$tutor['tutor_id']]);
                $availability = $availabilityStmt->fetchAll(PDO::FETCH_ASSOC);

                $formattedAvailability = array_map(function ($slot) {
                    return "{$slot['day']} ({$slot['starting_time']} - {$slot['ending_time']})";
                }, $availability);

                $tutor['availability'] = implode(', ', $formattedAvailability);
            }

            return $tutors;

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}
