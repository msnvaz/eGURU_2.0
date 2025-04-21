<?php 

namespace App\Models\tutor;

use PDO;
use PDOException;
use App\Config\Database;

class FeedbackModel {
    private $conn;  // Correctly storing DB connection

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();  // Assigning connection to $conn
    }

    // Fetch feedbacks by tutor ID
    public function getFeedbacksByTutor($tutorId) {
        $query = "SELECT 
                    sf.feedback_id, 
                    sf.student_feedback, 
                    sf.time_created,
                    sf.session_id,
                    sf.session_rating,
                    s.student_id, 
                    s.student_profile_photo,
                    CONCAT(s.student_first_name, ' ', s.student_last_name) AS student_name,
                    CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) AS tutor_name,
                    sf.tutor_reply
                  FROM session_feedback sf
                  JOIN session se ON sf.session_id = se.session_id
                  JOIN student s ON se.student_id = s.student_id
                  JOIN tutor t ON se.tutor_id = t.tutor_id
                  WHERE se.tutor_id = :tutorId
                  ORDER BY sf.time_created DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutorId', $tutorId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch rating by tutor ID
    public function getRatingByTutor($tutorId) {
        $query = "SELECT ROUND(AVG(session_rating), 1) 
              FROM session_feedback 
              WHERE session_id IN 
                    (SELECT session_id FROM session WHERE tutor_id = :tutorId)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutorId', $tutorId);
        $stmt->execute();
        
        return $stmt->fetchColumn();
    }
    

   // Save a tutor's reply to a feedback
    public function saveReply($feedbackId, $replyMessage) {
        // Check if a reply already exists for this feedback
        $query = "SELECT * FROM session_feedback WHERE feedback_id = :feedbackId AND tutor_reply IS NOT NULL";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':feedbackId', $feedbackId);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return false; // A reply already exists for this feedback
        }

        // Save the tutor's reply to the feedback
        $query = "UPDATE session_feedback SET tutor_reply = :replyMessage WHERE feedback_id = :feedbackId";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':replyMessage', $replyMessage);
        $stmt->bindParam(':feedbackId', $feedbackId);
        
        return $stmt->execute();
    }

    public function updateReply($feedbackId, $replyMessage) {
        // Ensure that the feedback exists and has a reply
        $query = "SELECT feedback_id FROM session_feedback WHERE feedback_id = :feedbackId AND tutor_reply IS NOT NULL";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':feedbackId', $feedbackId);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return false; // Reply not found or doesn't exist
        }

        // Update the reply
        $query = "UPDATE session_feedback SET tutor_reply = :replyMessage WHERE feedback_id = :feedbackId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':replyMessage', $replyMessage);
        $stmt->bindParam(':feedbackId', $feedbackId);

        return $stmt->execute();
    }

}
