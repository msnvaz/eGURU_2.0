<?php
namespace App\Models\student;

use PDO;

class EventModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUpcomingEvents($student_id) {
        $query = "
            SELECT 
                s.session_id,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                s.meeting_link,
                sub.subject_name,
                CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) AS tutor_name,
                t.tutor_profile_photo,
                st.student_grade AS grade
            FROM session s
            JOIN subject sub ON s.subject_id = sub.subject_id
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN student st ON s.student_id = st.student_id
            WHERE s.student_id = :student_id 
            AND s.session_status = 'scheduled'
            ORDER BY s.scheduled_date, s.schedule_time
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPreviousEvents($student_id) {
        $query = "
            SELECT 
                s.session_id,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                s.meeting_link,
                sub.subject_name,
                CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) AS tutor_name,
                t.tutor_profile_photo,
                st.student_grade AS grade
            FROM session s
            JOIN subject sub ON s.subject_id = sub.subject_id
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN student st ON s.student_id = st.student_id
            WHERE s.student_id = :student_id 
            AND s.session_status = 'completed'
            ORDER BY s.scheduled_date DESC, s.schedule_time DESC
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventsByDate($date, $student_id) {
        $query = "
            SELECT 
                s.session_id,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                s.meeting_link,
                sub.subject_name,
                CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) AS tutor_name,
                t.tutor_profile_photo,
                st.student_grade AS grade
            FROM session s
            JOIN subject sub ON s.subject_id = sub.subject_id
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN student st ON s.student_id = st.student_id
            WHERE s.student_id = :student_id 
            AND s.scheduled_date = :date
            ORDER BY s.schedule_time
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventDatesInMonth($month, $year, $student_id) {
        $query = "
            SELECT DISTINCT s.scheduled_date, s.session_status
            FROM session s
            WHERE s.student_id = :student_id 
            AND MONTH(s.scheduled_date) = :month 
            AND YEAR(s.scheduled_date) = :year
            AND s.session_status IN ('scheduled', 'completed')
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLimitedUpcomingEvents($student_id, $limit) {
        $query = "
            SELECT 
                s.session_id,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                s.meeting_link,
                sub.subject_name,
                CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) AS tutor_name,
                t.tutor_profile_photo,
                st.student_grade AS grade
            FROM session s
            JOIN subject sub ON s.subject_id = sub.subject_id
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN student st ON s.student_id = st.student_id
            WHERE s.student_id = :student_id 
            AND s.session_status = 'scheduled'
            ORDER BY s.scheduled_date, s.schedule_time
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLimitedPreviousEvents($student_id, $limit) {
        $query = "
            SELECT 
                s.session_id,
                s.scheduled_date,
                s.schedule_time,
                s.session_status,
                s.meeting_link,
                sub.subject_name,
                CONCAT(t.tutor_first_name, ' ', t.tutor_last_name) AS tutor_name,
                t.tutor_profile_photo,
                st.student_grade AS grade
            FROM session s
            JOIN subject sub ON s.subject_id = sub.subject_id
            JOIN tutor t ON s.tutor_id = t.tutor_id
            JOIN student st ON s.student_id = st.student_id
            WHERE s.student_id = :student_id 
            AND s.session_status = 'completed'
            ORDER BY s.scheduled_date DESC, s.schedule_time DESC
            LIMIT :limit
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}