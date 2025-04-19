<?php

namespace App\Models\tutor;

use App\Config\database;
use PDO;

class TutorStudyMaterialModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllStudyMaterials($tutorId) {
        $status = 'set';
        $query = "SELECT sm.*, s.subject_name 
                  FROM tutor_study_material sm
                  JOIN subject s ON sm.subject_id = s.subject_id
                  WHERE sm.tutor_id = :tutorId AND sm.material_status = :status
                  ORDER BY sm.material_id DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutorId', $tutorId);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSubjects() {
        $query = "SELECT subject_id, subject_name FROM subject ORDER BY subject_name ASC";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    public function addStudyMaterial($fileName, $description, $tutorId, $subjectId, $grade) {
        $query = "INSERT INTO tutor_study_material (material_path, material_description, tutor_id, subject_id, grade, material_status) 
                  VALUES (:fileName, :description, :tutorId, :subjectId, :grade, 'set')";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':fileName' => $fileName,
            ':description' => $description,
            ':tutorId' => $tutorId,
            ':subjectId' => $subjectId,
            ':grade' => $grade
        ]);
    }
    
    

    
    public function deleteStudyMaterialById($materialId) {
        $query = "UPDATE tutor_study_material SET material_status = 'unset' WHERE material_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $materialId]);
    }

    
    public function updateStudyMaterial($materialId, $description, $grade, $subject_id) {
        $query = "UPDATE tutor_study_material 
                  SET material_description = :description, grade = :grade, subject_id =:subject_id 
                  WHERE material_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'description' => $description,
            'grade' => $grade,
            'subject_id' => $subject_id,
            'id' => $materialId
        ]);
    }
    

    
}