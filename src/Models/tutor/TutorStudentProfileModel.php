<?php

namespace App\Models\tutor;

use App\config\Database;
use PDO;

class TutorStudentProfileModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getProfileByStudentId($studentId) {
        $sql = "SELECT * FROM student_profile WHERE student_id = :student_id";
        $stmt = $this->conn->prepare($sql); // Fixed here
        $stmt->execute([':student_id' => $studentId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getStudentContactInfo($studentId) {
        $sql = "SELECT * FROM student WHERE student_id = :student_id";
        $stmt = $this->conn->prepare($sql); // Fixed here
        $stmt->execute([':student_id' => $studentId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }
}
