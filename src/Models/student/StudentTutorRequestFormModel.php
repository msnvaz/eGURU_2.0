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
            ts.starting_time,
            ts.ending_time
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
        LEFT JOIN 
            session sess ON 
                sess.tutor_id = ta.tutor_id AND 
                sess.student_id = sa.student_id AND 
                sess.scheduled_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY) AND
                sess.session_status IN ('scheduled', 'requested')
        WHERE 
            ta.tutor_id = :tutor_id AND
            sa.student_id = :student_id AND
            sess.session_id IS NULL
        ORDER BY 
            ta.day, ts.starting_time";
        $params = [
            ':tutor_id' => $tutor_id,
            ':student_id' => $student_id
        ];
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    //get tutor subjects
}