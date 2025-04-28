<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class TutorSearchModel
{
    public function getFilteredTutors($filters)
    {
        $whereClauses = [];
        $params = [];

        if (!empty($filters['grade'])) {
            $whereClauses[] = "tg.grade = ?";
            $params[] = $filters['grade'];
        }

        if (!empty($filters['subject'])) {
            $whereClauses[] = "sname.subject_name = ?";
            $params[] = $filters['subject'];
        }

        if (!empty($filters['level'])) {
            $whereClauses[] = "t.tutor_level_id = ?";
            $params[] = $filters['level'];
        }

        $sql = "
    SELECT 
        t.tutor_id,
        t.tutor_first_name,
        t.tutor_last_name,
        tl.tutor_level_qualification,
        GROUP_CONCAT(
            DISTINCT CONCAT(ta.day, ' (', ts.starting_time, ' - ', ts.ending_time, ')') 
            ORDER BY FIELD(ta.day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')
        ) AS availability
    FROM tutor t
    LEFT JOIN tutor_grades tg ON t.tutor_id = tg.tutor_id
    LEFT JOIN tutor_subject tsub ON t.tutor_id = tsub.tutor_id
    LEFT JOIN subject sname ON tsub.subject_id = sname.subject_id
    LEFT JOIN tutor_availability ta ON t.tutor_id = ta.tutor_id
    LEFT JOIN time_slot ts ON ta.time_slot_id = ts.time_slot_id
    LEFT JOIN tutor_level tl ON t.tutor_level_id = tl.tutor_level_id
    " . (!empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "") . "
    GROUP BY t.tutor_id";


        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
