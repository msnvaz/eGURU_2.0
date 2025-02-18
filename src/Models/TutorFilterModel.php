<?php
class TutorFilterModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "tutor_db");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getTutors($filters) {
        $sql = "SELECT * FROM tutors WHERE 1=1";

        if (!empty($filters['grade'])) {
            $sql .= " AND grade = '" . $this->conn->real_escape_string($filters['grade']) . "'";
        }
        if (!empty($filters['subject'])) {
            $sql .= " AND subject = '" . $this->conn->real_escape_string($filters['subject']) . "'";
        }
        if (!empty($filters['experience'])) {
            $sql .= " AND experience_level = '" . $this->conn->real_escape_string($filters['experience']) . "'";
        }
        if (!empty($filters['rating'])) {
            $sql .= " AND rating >= " . intval($filters['rating']);
        }
        if (!empty($filters['session_count'])) {
            $sql .= " AND session_count <= " . intval($filters['session_count']);
        }
        if (!empty($filters['availability'])) {
            $sql .= " AND availability = '" . $this->conn->real_escape_string($filters['availability']) . "'";
        }

        $result = $this->conn->query($sql);
        $tutors = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tutors[] = $row;
            }
        }

        return $tutors;
    }
}
?>
