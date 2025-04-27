<?php
namespace App\Models\student;

use App\config\database;
use PDO; 

class FeedbackModel {
    private $conn;
    private $hasSessionFeedbackStatus = false;
    
    public function __construct() {
        // First, add the deleted_at column if it doesn't exist
        $this->addDeletedAtColumn();
        
        $db = new Database();
        $this->conn = $db->connect();
        
        // Check if session_feedback_status exists
        $this->hasSessionFeedbackStatus = $this->checkColumnExists('session', 'session_feedback_status');
    }

    private function addDeletedAtColumn() {
        $db = new Database();
        $conn = $db->connect();
        
        $sql = "ALTER TABLE session_feedback ADD COLUMN IF NOT EXISTS deleted_at TIMESTAMP NULL DEFAULT NULL";
        $conn->exec($sql);
    }

    public function save_comment($student_id, $session_id, $student_feedback, $session_rating) {
        if ($this->hasSessionFeedbackStatus) {
            // Update the session_feedback_status to 'set'
            $statusQuery = $this->conn->prepare("
                UPDATE session_feedback 
                SET session_feedback_status = 'set'
                WHERE session_id = :session_id
            ");
            $statusQuery->execute(['session_id' => $session_id]);
        }
    
        // Insert the feedback using the database's NOW() function for time_created and last_updated
        $query = $this->conn->prepare("
            INSERT INTO session_feedback 
            (session_id, student_feedback, session_rating, last_updated, time_created) 
            VALUES (:session_id, :student_feedback, :session_rating, NOW(), NOW())
        ");
    
        $query->execute([
            'session_id' => $session_id,
            'student_feedback' => $student_feedback,
            'session_rating' => $session_rating
        ]);
    
        return $this->conn->lastInsertId();
    }
    public function update_comment($feedback_id, $student_feedback, $session_rating) {
        
        $query = $this->conn->prepare("
            UPDATE session_feedback 
            SET student_feedback = :student_feedback,
                session_rating = :session_rating,
                last_updated = NOW()
            WHERE feedback_id = :feedback_id
            AND deleted_at IS NULL
        ");
        
        $query->execute([
            'student_feedback' => $student_feedback,
            'session_rating' => $session_rating,
            'feedback_id' => $feedback_id
        ]);
        
        return true;
    }
    
    public function delete_comment($feedback_id) {
        // First get the session_id
        $getSessionQuery = $this->conn->prepare("
            SELECT session_id 
            FROM session_feedback 
            WHERE feedback_id = :feedback_id
            AND deleted_at IS NULL
        ");
        $getSessionQuery->execute(['feedback_id' => $feedback_id]);
        $session = $getSessionQuery->fetch(PDO::FETCH_ASSOC);
    
        if ($session) {
            // Start a transaction to ensure both updates happen or neither does
            $this->conn->beginTransaction();
    
            try {
                // Update the session_feedback_status to 'unset' and set real-time values for last_updated
                $statusQuery = $this->conn->prepare("
                    UPDATE session_feedback 
                    SET session_feedback_status = 'unset', 
                        last_updated = NOW(), 
                        deleted_at = NOW()
                    WHERE feedback_id = :feedback_id
                    AND deleted_at IS NULL
                ");
                $statusQuery->execute(['feedback_id' => $feedback_id]);
    
                $this->conn->commit();
                return true;
            } catch (\Exception $e) {
                $this->conn->rollBack();
                error_log("Error deleting feedback: " . $e->getMessage());
                return false;
            }
        }
    
        return false;
    }
    
    public function get_student_feedback($student_id) {
        $query = $this->conn->prepare("
            SELECT sf.feedback_id, sf.session_id, sf.student_feedback, 
                   sf.tutor_reply, sf.session_rating, sf.last_updated,
                   sf.time_created,
                   t.tutor_first_name, t.tutor_last_name, t.tutor_profile_photo
            FROM session_feedback sf
            JOIN session s ON sf.session_id = s.session_id
            JOIN tutor t ON s.tutor_id = t.tutor_id
            WHERE s.student_id = :student_id
            AND sf.deleted_at IS NULL
            ORDER BY sf.last_updated DESC
        ");
        
        $query->execute(['student_id' => $student_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function get_completed_session_tutors($student_id) {
        $query = $this->conn->prepare("
            SELECT DISTINCT t.tutor_id, t.tutor_first_name, t.tutor_last_name, 
                   t.tutor_profile_photo, s.session_id, s.subject_id,
                   sub.subject_name
            FROM session s
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN subject sub ON s.subject_id = sub.subject_id
            WHERE s.student_id = :student_id
            AND s.session_status = 'completed'
            AND NOT EXISTS (
                SELECT 1 
                FROM session_feedback sf 
                WHERE sf.session_id = s.session_id 
                AND sf.deleted_at IS NULL
            )
        ");
        
        $query->execute(['student_id' => $student_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function check_existing_feedback($session_id) {
        $query = $this->conn->prepare("
            SELECT feedback_id 
            FROM session_feedback 
            WHERE session_id = :session_id
            AND deleted_at IS NULL
        ");
        
        $query->execute(['session_id' => $session_id]);
        return $query->rowCount() > 0;
    }
    
    public function verify_session_ownership($session_id, $student_id) {
        $query = $this->conn->prepare("
            SELECT session_id 
            FROM session 
            WHERE session_id = :session_id 
            AND student_id = :student_id
        ");
        
        $query->execute([
            'session_id' => $session_id,
            'student_id' => $student_id
        ]);
        
        return $query->rowCount() > 0;
    }
    
    public function verify_feedback_ownership($feedback_id, $student_id) {
        $query = $this->conn->prepare("
            SELECT sf.feedback_id 
            FROM session_feedback sf
            JOIN session s ON sf.session_id = s.session_id
            WHERE sf.feedback_id = :feedback_id 
            AND s.student_id = :student_id
            AND sf.deleted_at IS NULL
        ");
        
        $query->execute([
            'feedback_id' => $feedback_id,
            'student_id' => $student_id
        ]);
        
        return $query->rowCount() > 0;
    }
    
    private function checkColumnExists($table, $column) {
        $query = $this->conn->prepare("
            SELECT 1 
            FROM information_schema.columns 
            WHERE table_name = :table 
            AND column_name = :column
        ");
        
        $query->execute([
            'table' => $table,
            'column' => $column
        ]);
        
        return $query->rowCount() > 0;
    }
}