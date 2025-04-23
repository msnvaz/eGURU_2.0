<?php

namespace App\Models\student;

use App\Config\Database;
use PDO;

class TimeslotModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Get all time slots
    public function getAllTimeSlots() {
        $stmt = $this->conn->prepare("SELECT * FROM time_slot ORDER BY starting_time ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get selected time slots for a tutor for all days
    public function getStudentTimeSlots($studentId) {
        $stmt = $this->conn->prepare("SELECT day, time_slot_id FROM student_availability WHERE student_id = ?");
        $stmt->execute([$studentId]);

        $results = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $results[$row['day']][] = $row['time_slot_id'];
        }

        return $results; // e.g. ['Monday' => [1,2], 'Tuesday' => [3]]
    }

    // Save selected time slots for each day
    public function saveStudentTimeSlots($studentId, $selections) {
        // Delete all previous
        $stmt = $this->conn->prepare("DELETE FROM student_availability WHERE student_id = ?");
        $stmt->execute([$studentId]);

        // Insert new ones
        $stmt = $this->conn->prepare("INSERT INTO student_availability (student_id, time_slot_id, day) VALUES (?, ?, ?)");

        foreach ($selections as $day => $slotIds) {
            foreach ($slotIds as $slotId) {
                $stmt->execute([$studentId, $slotId, $day]);
            }
        }
    }
}
