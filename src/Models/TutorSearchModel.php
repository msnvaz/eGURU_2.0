<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class TutorSearchModel
{
    public function getFilteredTutors($filters)
    {
        $whereClauses = [];
        $havingConditions = [];
        $params = [];

        // Grade filter
        if (!empty($filters['grade'])) {
            $whereClauses[] = "tg.grade = ?";
            $params[] = $filters['grade'];
        }

        // Subject filter (FIXED to use subject table alias 'sname')
        if (!empty($filters['subject'])) {
            $whereClauses[] = "sname.subject_name = ?";
            $params[] = $filters['subject'];
        }

        // Level filter
        if (!empty($filters['level'])) {
            $whereClauses[] = "t.tutor_level_id = ?";
            $params[] = $filters['level'];
        }

        // Rating filter (HAVING)
        if (!empty($filters['rating'])) {
            $havingConditions[] = "average_rating >= ?";
            $params[] = $filters['rating'];
        }

        // Session count filter (HAVING)
        if (!empty($filters['session_count'])) {
            if ($filters['session_count'] == 5) {
                $havingConditions[] = "completed_sessions <= 5";
            } elseif ($filters['session_count'] == 10) {
                $havingConditions[] = "completed_sessions <= 10";
            } else {
                $havingConditions[] = "completed_sessions > 10";
            }
        }

        // SQL Query
        $sql = "
            SELECT 
                t.tutor_id,
                t.tutor_first_name,
                t.tutor_last_name,
                t.tutor_level_id,
                GROUP_CONCAT(
                    DISTINCT CONCAT(ta.day, ' (', ts.starting_time, ' - ', ts.ending_time, ')') 
                    ORDER BY FIELD(ta.day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')
                ) AS availability,
                COUNT(CASE WHEN s.session_status = 'completed' THEN 1 END) AS completed_sessions,
                AVG(CASE WHEN s.session_status = 'completed' THEN sf.session_rating END) AS average_rating
            FROM tutor t
            LEFT JOIN tutor_grades tg ON t.tutor_id = tg.tutor_id
            LEFT JOIN tutor_subject tsub ON t.tutor_id = tsub.tutor_id
            LEFT JOIN subject sname ON tsub.subject_id = sname.subject_id
            LEFT JOIN session s ON s.tutor_id = t.tutor_id
            LEFT JOIN session_feedback sf ON sf.session_id = s.session_id
            LEFT JOIN tutor_availability ta ON t.tutor_id = ta.tutor_id
            LEFT JOIN time_slot ts ON ta.time_slot_id = ts.time_slot_id
            " . (!empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "") . "
            GROUP BY t.tutor_id
            " . (!empty($havingConditions) ? "HAVING " . implode(" AND ", $havingConditions) : "");

        // Execute
        $db = new Database();
        $conn = $db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
