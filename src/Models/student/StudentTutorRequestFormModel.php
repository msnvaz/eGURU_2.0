<?php

namespace App\Models\student;

use App\Config\Database;
use PDO;

class StudentTutorRequestFormModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    //available time slots filtered with upcoming sessions
    public function getAvailableTimeSlots($tutor_id,$student_id) {
        $query ="
       SELECT
            ta.tutor_id,
            t.tutor_first_name,
            t.tutor_last_name,
            sa.student_id,
            s.student_first_name,
            s.student_last_name,
            ta.day,
            CONCAT(ts.starting_time, ':00') as starting_time,
            CONCAT(ts.ending_time, ':00') as ending_time,
            ta.time_slot_id
        FROM
            tutor_availability ta
        INNER JOIN
            student_availability sa ON sa.time_slot_id = ta.time_slot_id AND sa.day = ta.day
        INNER JOIN
            tutor t ON t.tutor_id = ta.tutor_id
        INNER JOIN
            student s ON s.student_id = sa.student_id
        INNER JOIN
            time_slot ts ON ts.time_slot_id = ta.time_slot_id
        WHERE
            ta.tutor_id = :tutor_id AND
            sa.student_id = :student_id AND
            NOT EXISTS (
                SELECT 1
                FROM session sess
                WHERE
                    sess.tutor_id = ta.tutor_id AND
                    sess.student_id = sa.student_id AND
                    sess.session_status IN ('scheduled', 'requested') AND
                    DATE_FORMAT(sess.scheduled_date, '%W') = ta.day AND
                    (
                        (HOUR(sess.schedule_time) >= ts.starting_time AND HOUR(sess.schedule_time) < ts.ending_time) OR
                        (HOUR(sess.schedule_time) < ts.starting_time AND (HOUR(sess.schedule_time) + 2) > ts.starting_time)
                    )
            )
        ORDER BY
            FIELD(ta.day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
            ts.starting_time";
        $params = [
            ':tutor_id' => $tutor_id,
            ':student_id' => $student_id
        ];
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //get tutor subjects from tutor_subject table and subject table
    //get tutor level id from tutor table and get the tutor level (name),tutor_pay_per_hour from level table
    public function getTutorSubjects($tutor_id) {
        $query = "
        SELECT 
            ts.tutor_id,
            t.tutor_first_name,
            t.tutor_last_name,
            s.subject_name,
            s.subject_id,
            l.tutor_level,
            l.tutor_pay_per_hour
        FROM 
            tutor_subject ts
        INNER JOIN 
            subject s ON ts.subject_id = s.subject_id
        INNER JOIN 
            tutor t ON ts.tutor_id = t.tutor_id
        INNER JOIN 
            tutor_level l ON t.tutor_level_id = l.tutor_level_id
        WHERE 
            ts.tutor_id = :tutor_id
        GROUP BY 
            ts.tutor_id, s.subject_name, l.tutor_level, l.tutor_pay_per_hour
        ORDER BY 
            s.subject_name, l.tutor_level";
        $params = [
            ':tutor_id' => $tutor_id
        ];
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //get the next possible session day and time slot for a given time slot id and day within the next 7 days
    public function getNextSessionDate($time_slot_id, $day) {
        $query = "
        SELECT 
            ts.starting_time,
            ts.ending_time,
            DATE_ADD(CURDATE(), INTERVAL (7 + (7 - WEEKDAY(CURDATE()) + :day)) % 7 DAY) AS next_session_date
        FROM 
            time_slot ts
        WHERE 
            ts.time_slot_id = :time_slot_id";
        $params = [
            ':time_slot_id' => $time_slot_id,
            ':day' => $day
        ];
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    
    //insert student_id,tutor_id,scheduled_date,schedule_time,session_status,subject_id to session table
    public function insertSession($student_id, $tutor_id, $scheduled_date, $schedule_time, $session_status, $subject_id) {
        try {
            // Format the time properly if needed
            if (strpos($schedule_time, ' - ') !== false) {
                $schedule_time = trim(explode(' - ', $schedule_time)[0]);
            }
            
            // Make sure time is in proper format (HH:MM:SS)
            if (strpos($schedule_time, ':') !== false && substr_count($schedule_time, ':') === 1) {
                $schedule_time .= ':00';  // Add seconds if missing
            }
            
            $query = "
            INSERT INTO session (student_id, tutor_id, scheduled_date, schedule_time, session_status, subject_id)
            VALUES (:student_id, :tutor_id, :scheduled_date, :schedule_time, :session_status, :subject_id)";
            $params = [
                ':student_id' => $student_id,
                ':tutor_id' => $tutor_id,
                ':scheduled_date' => $scheduled_date,
                ':schedule_time' => $schedule_time,
                ':session_status' => $session_status,
                ':subject_id' => $subject_id
            ];
            
            // For debugging
            error_log("Inserting session with data: " . json_encode($params));
            
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Database error in insertSession: " . $e->getMessage());
            return false;
        }
    }
}