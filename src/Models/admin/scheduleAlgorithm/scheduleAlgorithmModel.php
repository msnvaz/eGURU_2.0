<?php
namespace App\Models\scheduleAlgorithm;

use App\Config\Database;
use PDO;
use PDOException;

class scheduleAlgorithmModel {
    private $conn;

    public function __construct() {
        // Initialize the Database class and get the connection
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    //check availablity of tutor and student
    public function checkAvailability($tutor_id, $student_id) {
        $query="SELECT 
                    sa.day,
                    ts.time_slot_id,
                    ts.starting_time,
                    ts.ending_time
                FROM 
                    student_availability sa
                JOIN 
                    tutor_availability ta ON sa.time_slot_id = ta.time_slot_id AND sa.day = ta.day
                JOIN 
                    time_slot ts ON sa.time_slot_id = ts.time_slot_id
                WHERE 
                    sa.student_id = $student_id  
                    AND ta.tutor_id = $tutor_id  
                    AND NOT EXISTS (
                        SELECT 1
                        FROM session s
                        WHERE 
                            s.student_id = sa.student_id
                            AND s.tutor_id = ta.tutor_id
                            -- Convert day of week to a date in the coming week
                            AND s.scheduled_date = DATE_ADD(CURRENT_DATE(), INTERVAL (CASE 
                                WHEN sa.day = 'Monday' THEN (7 + 1 - DAYOFWEEK(CURRENT_DATE())) MOD 7
                                WHEN sa.day = 'Tuesday' THEN (7 + 2 - DAYOFWEEK(CURRENT_DATE())) MOD 7
                                WHEN sa.day = 'Wednesday' THEN (7 + 3 - DAYOFWEEK(CURRENT_DATE())) MOD 7
                                WHEN sa.day = 'Thursday' THEN (7 + 4 - DAYOFWEEK(CURRENT_DATE())) MOD 7
                                WHEN sa.day = 'Friday' THEN (7 + 5 - DAYOFWEEK(CURRENT_DATE())) MOD 7
                                WHEN sa.day = 'Saturday' THEN (7 + 6 - DAYOFWEEK(CURRENT_DATE())) MOD 7
                                WHEN sa.day = 'Sunday' THEN (7 + 7 - DAYOFWEEK(CURRENT_DATE())) MOD 7
                                END) DAY)
                            -- Check if session time overlaps with the time slot
                            AND TIME(s.schedule_time) >= MAKETIME(ts.starting_time, 0, 0)
                            AND TIME(s.schedule_time) < MAKETIME(ts.ending_time, 0, 0)
                            AND s.session_status IN ('scheduled', 'requested')
                    )
                ORDER BY 
                    CASE 
                        WHEN sa.day = 'Monday' THEN 1
                        WHEN sa.day = 'Tuesday' THEN 2
                        WHEN sa.day = 'Wednesday' THEN 3
                        WHEN sa.day = 'Thursday' THEN 4
                        WHEN sa.day = 'Friday' THEN 5
                        WHEN sa.day = 'Saturday' THEN 6
                        WHEN sa.day = 'Sunday' THEN 7
                    END,
                    ts.starting_time;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutor_id', $tutor_id);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}