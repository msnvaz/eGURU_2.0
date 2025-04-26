<?php 

namespace App\Models\tutor;

use PDO;
use PDOException;
use App\Config\Database;

class SessionsModel {
    private $conn;  // Correctly storing DB connection

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();  // Assigning connection to $conn
    }

    public function getUpcomingEvents($tutorId) {
        $query = "SELECT 
                    subject.subject_name AS subject_name, 
                    student.student_id,
                    student.student_first_name, 
                    student.student_last_name, 
                    student.student_grade,
                    student.student_profile_photo,
                    session.session_id,
                    session.scheduled_date, 
                    session.schedule_time,
                    session.session_status,
                    session.meeting_link
                  FROM session
                  JOIN subject ON session.subject_id = subject.subject_id
                  JOIN student ON session.student_id = student.student_id  
                  WHERE session.tutor_id = :tutorId 
                  AND session.scheduled_date >= CURDATE() 
                  AND session.session_status = 'Scheduled'
                  ORDER BY session.scheduled_date ASC";
    
        $stmt = $this->conn->prepare($query);  
        $stmt->bindParam(':tutorId', $tutorId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    public function getPreviousEvents($tutorId) {
        $query = "SELECT 
                    subject.subject_name AS subject_name,
                    student.student_id, 
                    student.student_first_name, 
                    student.student_last_name, 
                    session.scheduled_date, 
                    session.schedule_time,
                    student.student_grade
                  FROM session
                  JOIN subject ON session.subject_id = subject.subject_id
                  JOIN student ON session.student_id = student.student_id
                  WHERE session.tutor_id = :tutorId 
                  AND session.scheduled_date <= CURDATE()
                  AND session.session_status = 'Completed' 
                  ORDER BY session.scheduled_date DESC";  

        $stmt = $this->conn->prepare($query); 
        $stmt->bindParam(':tutorId', $tutorId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getRequestedSessionsByTutor($tutorId) {
        $sql = "SELECT s.student_id, s.session_id, s.scheduled_date, s.schedule_time, st.student_first_name, st.student_last_name, subj.subject_name 
                FROM session s
                JOIN student st ON s.student_id = st.student_id
                JOIN subject subj ON s.subject_id = subj.subject_id
                WHERE s.session_status = 'requested' AND s.tutor_id = :tutor_id
                ORDER BY s.scheduled_date ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tutor_id', $tutorId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRejectedSessionsByTutor($tutorId) {
        $sql = "SELECT st.student_id, s.session_id, s.scheduled_date, s.schedule_time, st.student_first_name, st.student_last_name, subj.subject_name 
                FROM session s
                JOIN student st ON s.student_id = st.student_id
                JOIN subject subj ON s.subject_id = subj.subject_id
                WHERE s.session_status = 'rejected' AND s.tutor_id = :tutor_id
                ORDER BY s.scheduled_date ASC";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tutor_id', $tutorId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateSessionStatus($sessionId, $status) {
        $sql = "UPDATE session SET session_status = :status WHERE session_id = :session_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':session_id', $sessionId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getEventDatesInMonth($month, $year, $tutor_id) {
        $query = "
            SELECT DISTINCT s.scheduled_date, s.session_status
            FROM session s
            WHERE s.tutor_id = :tutor_id 
            AND MONTH(s.scheduled_date) = :month 
            AND YEAR(s.scheduled_date) = :year
            AND s.session_status IN ('scheduled', 'completed')
        ";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutor_id', $tutor_id, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventsByDate($date, $tutor_id) {
        $query = "
            SELECT 
                s.session_id,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                s.meeting_link,
                sub.subject_name,
                CONCAT(st.student_first_name, ' ', st.student_last_name) AS student_name,
                st.student_profile_photo,
                st.student_grade AS grade
            FROM session s
            JOIN subject sub ON s.subject_id = sub.subject_id
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN student st ON s.student_id = st.student_id
            WHERE s.tutor_id = :tutor_id 
            AND s.scheduled_date = :date
            ORDER BY s.schedule_time
        ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutor_id', $tutor_id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
}