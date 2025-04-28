<?php 

namespace App\Models\tutor;

use PDO;
use PDOException;
use App\Config\Database;

class SessionsModel {
    private $conn;  

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();  
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
                    session.session_id,
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

    public function getCancelledSessionsByTutor($tutorId) {
        $sql = "SELECT st.student_id, s.session_id, s.scheduled_date, s.schedule_time, st.student_first_name, st.student_last_name, subj.subject_name 
                FROM session s
                JOIN student st ON s.student_id = st.student_id
                JOIN subject subj ON s.subject_id = subj.subject_id
                WHERE s.session_status = 'cancelled' AND s.tutor_id = :tutor_id
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

    public function updateCompletedSessionsAndPayments()
{
    $now = date('Y-m-d H:i:s'); 
    $today = date('Y-m-d'); 

    
    $query = "
        SELECT s.*, t.tutor_level_id, tl.tutor_pay_per_hour
        FROM session s
        INNER JOIN tutor t ON s.tutor_id = t.tutor_id
        INNER JOIN tutor_level tl ON t.tutor_level_id = tl.tutor_level_id
        WHERE s.session_status = 'scheduled'
          AND s.scheduled_date <= :today
          AND s.schedule_time <= DATE_SUB(:now, INTERVAL 2 HOUR)
    ";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':today', $today);
    $stmt->bindParam(':now', $now);
    $stmt->execute();

    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($sessions as $session) {
        $sessionId = $session['session_id'];
        $studentId = $session['student_id'];
        $tutorId = $session['tutor_id'];
        $payPerHour = $session['tutor_pay_per_hour'];

        $paymentPointAmount = $payPerHour * 2; 
        $paymentTime = date('Y-m-d H:i:s'); 
        $paymentStatus = 'okay'; 

        $this->conn->beginTransaction(); 

        try {
            
            $updateSession = "
                UPDATE session 
                SET session_status = 'completed' 
                WHERE session_id = :session_id
            ";
            $stmtUpdate = $this->conn->prepare($updateSession);
            $stmtUpdate->bindParam(':session_id', $sessionId, PDO::PARAM_INT);
            $stmtUpdate->execute();

            
            $insertPayment = "
                INSERT INTO session_payment 
                (session_id, student_id, tutor_id, payment_point_amount, payment_status, payment_time)
                VALUES 
                (:session_id, :student_id, :tutor_id, :payment_point_amount, :payment_status, :payment_time)
            ";
            $stmtInsert = $this->conn->prepare($insertPayment);
            $stmtInsert->bindParam(':session_id', $sessionId, PDO::PARAM_INT);
            $stmtInsert->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmtInsert->bindParam(':tutor_id', $tutorId, PDO::PARAM_INT);
            $stmtInsert->bindParam(':payment_point_amount', $paymentPointAmount, PDO::PARAM_INT);
            $stmtInsert->bindParam(':payment_status', $paymentStatus);
            $stmtInsert->bindParam(':payment_time', $paymentTime);
            $stmtInsert->execute();

            
            $updateTutorPoints = "
                UPDATE tutor 
                SET tutor_points = tutor_points + :points 
                WHERE tutor_id = :tutor_id
            ";
            $stmtTutorPoints = $this->conn->prepare($updateTutorPoints);
            $stmtTutorPoints->bindParam(':points', $paymentPointAmount, PDO::PARAM_INT);
            $stmtTutorPoints->bindParam(':tutor_id', $tutorId, PDO::PARAM_INT);
            $stmtTutorPoints->execute();

           
            $updateStudentPoints = "
                UPDATE student 
                SET student_points = student_points - :points 
                WHERE student_id = :student_id
            ";
            $stmtStudentPoints = $this->conn->prepare($updateStudentPoints);
            $stmtStudentPoints->bindParam(':points', $paymentPointAmount, PDO::PARAM_INT);
            $stmtStudentPoints->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmtStudentPoints->execute();

            $this->conn->commit(); 
        } catch (Exception $e) {
            $this->conn->rollBack(); 
            throw $e;
        }
    }
}

    
    
}