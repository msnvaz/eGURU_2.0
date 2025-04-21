<?php

namespace App\Models\tutor;

use App\Config\Database;
use PDO;

class TutorTimeSlotModel {
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
    public function getTutorTimeSlots($tutorId) {
        $stmt = $this->conn->prepare("SELECT day, time_slot_id FROM tutor_availability WHERE tutor_id = ?");
        $stmt->execute([$tutorId]);

        $results = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $results[$row['day']][] = $row['time_slot_id'];
        }

        return $results; // e.g. ['Monday' => [1,2], 'Tuesday' => [3]]
    }

    // Save selected time slots for each day
    public function saveTutorTimeSlots($tutorId, $selections) {
        // Delete all previous
        $stmt = $this->conn->prepare("DELETE FROM tutor_availability WHERE tutor_id = ?");
        $stmt->execute([$tutorId]);

        // Insert new ones
        $stmt = $this->conn->prepare("INSERT INTO tutor_availability (tutor_id, time_slot_id, day) VALUES (?, ?, ?)");

        foreach ($selections as $day => $slotIds) {
            foreach ($slotIds as $slotId) {
                $stmt->execute([$tutorId, $slotId, $day]);
            }
        }
    }
}
