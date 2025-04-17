<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class TutorSearchModel{

public function getFilteredTutors($filters) {
    include "config.php"; // database connection

    $whereClauses = [];
    $params = [];

    // Grade filter (JOIN with tutor_grade)
    if (!empty($filters['grade'])) {
        $whereClauses[] = "tg.grade = ?";
        $params[] = $filters['grade'];
    }

    // Subject filter (JOIN with session table)
    if (!empty($filters['subject'])) {
        $whereClauses[] = "s.subject_id = ?";
        $params[] = $filters['subject'];
    }

    // Tutor level filter
    if (!empty($filters['level'])) {
        $whereClauses[] = "t.level = ?";
        $params[] = $filters['level'];
    }

    // Rating filter (HAVING clause)
    $havingClause = "";
    if (!empty($filters['rating'])) {
        $havingClause = "HAVING AVG(sf.rating) >= ?";
        $params[] = $filters['rating'];
    }

    // Session count filter (based on completed sessions for the subject)
    if (!empty($filters['session_count'])) {
        if ($filters['session_count'] == 5) {
            $sessionFilter = "HAVING completed_sessions <= 5";
        } elseif ($filters['session_count'] == 10) {
            $sessionFilter = "HAVING completed_sessions <= 10";
        } else {
            $sessionFilter = "HAVING completed_sessions > 10";
        }
    } else {
        $sessionFilter = "";
    }

    $sql = "
        SELECT 
            t.tutor_id,
            t.tutor_first_name,
            t.tutor_last_name,
            t.level,
            t.availability,
            COUNT(CASE WHEN s.session_status = 'completed' THEN 1 END) AS completed_sessions,
            AVG(sf.rating) AS average_rating
        FROM tutor t
        LEFT JOIN tutor_grade tg ON t.tutor_id = tg.tutor_id
        LEFT JOIN session s ON s.tutor_id = t.tutor_id
        LEFT JOIN session_feedback sf ON sf.session_id = s.session_id
        " . (!empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "") . "
        GROUP BY t.tutor_id
        $havingClause
        $sessionFilter
    ";

    $stmt = $GLOBALS['conn']->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
