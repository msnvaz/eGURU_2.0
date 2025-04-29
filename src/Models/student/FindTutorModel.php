<?php

namespace App\Models\student;

use App\Config\Database;
use PDO;

class FindTutorModel {
    private $conn;
    private $db;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function searchTutors($grade, $subject, $experience, $studentId)
    {
        $query = "
            WITH matching_time_slots AS (
                SELECT DISTINCT ta.tutor_id
                FROM tutor_availability ta
                INNER JOIN student_availability sa ON 
                    sa.time_slot_id = ta.time_slot_id AND 
                    sa.day = ta.day
                WHERE sa.student_id = :student_id
            )
            SELECT DISTINCT 
                t.tutor_id,
                t.tutor_first_name,
                t.tutor_last_name,
                t.tutor_profile_photo,
                t.tutor_points,
                tl.tutor_level,
                tl.tutor_level_qualification,
                tl.tutor_level_color,
                GROUP_CONCAT(DISTINCT s.subject_name) as subjects,
                GROUP_CONCAT(DISTINCT tg.grade) as grades,
                (
                    SELECT GROUP_CONCAT(DISTINCT CONCAT(ta.time_slot_id, ' (', ta.day, ')'))
                    FROM tutor_availability ta
                    WHERE ta.tutor_id = t.tutor_id
                ) as available_times
            FROM tutor t
            INNER JOIN tutor_subject ts ON t.tutor_id = ts.tutor_id
            INNER JOIN subject s ON ts.subject_id = s.subject_id
            INNER JOIN tutor_grades tg ON t.tutor_id = tg.tutor_id
            INNER JOIN tutor_level tl ON t.tutor_level_id = tl.tutor_level_id
            INNER JOIN matching_time_slots mts ON t.tutor_id = mts.tutor_id
            WHERE 1=1
            " . ($grade ? "AND tg.grade = :grade" : "") . "
            " . ($subject ? "AND ts.subject_id = :subject" : "") . "
            " . ($experience ? "AND tl.tutor_level_qualification LIKE :experience" : "") . "
            GROUP BY 
                t.tutor_id,
                t.tutor_first_name,
                t.tutor_last_name,
                t.tutor_profile_photo,
                t.tutor_points,
                tl.tutor_level,
                tl.tutor_level_qualification,
                tl.tutor_level_color
            ORDER BY t.tutor_points DESC
        ";

        $params = [':student_id' => $studentId];
        if ($grade) $params[':grade'] = $grade;
        if ($subject) $params[':subject'] = $subject;
        if ($experience) $params[':experience'] = "%$experience%";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGrades()
    {
        $query = "SELECT DISTINCT grade FROM tutor_grades ORDER BY grade ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubjects()
    {
        $query = "
            SELECT DISTINCT s.subject_id, s.subject_name 
            FROM subject s
            INNER JOIN tutor_subject ts ON s.subject_id = ts.subject_id
            ORDER BY s.subject_name ASC
        ";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExperiences()
    {
        $query = "SELECT DISTINCT tutor_level_qualification AS experience FROM tutor_level ORDER BY experience ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function getStudentAvailability($studentId)
    {
        $query = "
            SELECT sa.time_slot_id, sa.day
            FROM student_availability sa
            WHERE sa.student_id = ?
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
public function getRequestedSessions($studentId)
{
    $query = "SELECT * FROM session WHERE student_id = ? AND session_status = 'requested'";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$studentId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getStudentPoints($studentId)
{
    $query = "SELECT student_points FROM student WHERE student_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->execute([$studentId]);
    $StudentPoints = (int)$stmt->fetchColumn();
    return $StudentPoints;
}
}