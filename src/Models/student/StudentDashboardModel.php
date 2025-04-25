<?php
namespace App\Models\student;

use App\config\database;
use PDO; 
class StudentDashboardModel {
    private $db;

    public function __construct() {
        // Database connection
        $this->db = new PDO("mysql:host=localhost;dbname=eguru", "root", "");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getTutorReplies($studentId) {
        try {
            $query = "
                SELECT 
                    sf.feedback_id,
                    sf.tutor_reply,
                    sf.last_updated,
                    t.tutor_first_name,
                    t.tutor_last_name,
                    t.tutor_profile_photo,
                    s.subject_name,
                    tl.tutor_level,
                    tl.tutor_level_color
                FROM session_feedback sf
                JOIN session ses ON sf.session_id = ses.session_id
                JOIN tutor t ON ses.tutor_id = t.tutor_id
                JOIN subject s ON ses.subject_id = s.subject_id
                JOIN tutor_level tl ON t.tutor_level_id = tl.tutor_level_id
                WHERE ses.student_id = :student_id 
                AND sf.tutor_reply IS NOT NULL
                ORDER BY sf.last_updated DESC
                LIMIT 3";

            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }


    public function getStudentPoints($studentId) {
        try {
            $query = "SELECT student_points FROM student WHERE student_id = :studentId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':studentId', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['student_points'] ?? 0;
        } catch (\PDOException $e) {
            error_log("Error fetching student points: " . $e->getMessage());
            return 0;
        }
    }
}