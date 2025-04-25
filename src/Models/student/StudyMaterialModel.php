<?php
namespace App\Models\student;
use App\Config\Database;
use PDO;

class StudyMaterialModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getTutorsWithCompletedSessions($studentId) {
        $query = "SELECT DISTINCT t.tutor_id, t.tutor_first_name AS first_name, t.tutor_last_name AS last_name
                  FROM session s
                  JOIN tutor t ON s.tutor_id = t.tutor_id
                  WHERE s.student_id = :student_id 
                  AND s.session_status = 'completed'
                  ORDER BY t.tutor_first_name, t.tutor_last_name";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubjectsFromCompletedSessions($studentId) {
        $query = "SELECT DISTINCT sub.subject_id, sub.subject_name
                  FROM session s
                  JOIN subject sub ON s.subject_id = sub.subject_id
                  WHERE s.student_id = :student_id 
                  AND s.session_status = 'completed'
                  ORDER BY sub.subject_name";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableMaterials($studentId) {
        $query = "SELECT sm.material_id, sm.material_description, sub.subject_name, t.tutor_first_name, t.tutor_last_name
                  FROM tutor_study_material sm
                  JOIN subject sub ON sm.subject_id = sub.subject_id
                  JOIN tutor t ON sm.tutor_id = t.tutor_id
                  WHERE sm.material_status = 'set'
                  ORDER BY sub.subject_name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredMaterials($studentId, $tutorId = null, $subjectId = null) {
        $query = "SELECT sm.material_id, sm.material_description, sub.subject_name, t.tutor_first_name, t.tutor_last_name
                  FROM tutor_study_material sm
                  JOIN subject sub ON sm.subject_id = sub.subject_id
                  JOIN tutor t ON sm.tutor_id = t.tutor_id
                  WHERE sm.material_status = 'set'";
    
        $params = [];
    
        if ($tutorId) {
            $query .= " AND sm.tutor_id = :tutor_id";
            $params[':tutor_id'] = $tutorId;
        }
    
        if ($subjectId) {
            $query .= " AND sm.subject_id = :subject_id";
            $params[':subject_id'] = $subjectId;
        }
    
        $query .= " ORDER BY sub.subject_name";
    
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


public function canStudentAccessMaterial($studentId, $materialId) {
    $query = "SELECT COUNT(*) as access
              FROM tutor_study_material sm
              JOIN session s ON sm.tutor_id = s.tutor_id
              WHERE sm.material_id = :material_id
              AND s.student_id = :student_id
              AND s.session_status = 'completed'";
              
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':material_id', $materialId, PDO::PARAM_INT);
    $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['access'] > 0;
}

public function getMaterialById($materialId) {
    $query = "SELECT sm.*, sub.subject_name
              FROM tutor_study_material sm
              JOIN subject sub ON sm.subject_id = sub.subject_id
              WHERE sm.material_id = :material_id
              AND sm.material_status = 'set'";
              
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':material_id', $materialId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return !empty($result) ? $result[0] : null;
}
}