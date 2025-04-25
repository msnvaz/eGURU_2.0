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
        $tutorId = 20021; // Replace with actual tutor ID or variable
        $studentId = 10021; // Replace with actual student ID or variable
        $query = "SELECT 
            ta.tutor_id,
            t.tutor_first_name,
            t.tutor_last_name,
            sa.student_id,
            s.student_first_name,
            s.student_last_name,
            ta.day,
            ts.start_time,
            ts.end_time
        FROM 
            tutor_availability ta
        INNER JOIN 
            student_availability sa ON sa.time_slot_id = ta.time_slot_id AND sa.day = ta.day
        INNER JOIN 
            tutor t ON t.tutor_id = ta.tutor_id
        INNER JOIN 
            student s ON s.student_id = sa.student_id
        INNER JOIN 
            time_slots ts ON ts.time_slot_id = ta.time_slot_id
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
            ta.day, ts.start_time";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':tutor_id' => $tutorId,
            ':student_id' => $studentId
        ]);
        $availableSessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}