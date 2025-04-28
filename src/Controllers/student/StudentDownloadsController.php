<?php
namespace App\Controllers\student;

use App\Models\student\StudyMaterialModel;

class StudentDownloadsController {
    private $studyMaterialModel;
    
    public function __construct() {
        $this->studyMaterialModel = new StudyMaterialModel();
    }
    
    private function getStudentId() {
        if (!isset($_SESSION['student_id'])) {
            header('Location: /student-login');
            exit;
        }
        return $_SESSION['student_id'];
    }
    
    public function showDownloads() {
        $studentId = $this->getStudentId();
        
        $completedTutors = $this->studyMaterialModel->getTutorsWithCompletedSessions($studentId);
        $completedSubjects = $this->studyMaterialModel->getSubjectsFromCompletedSessions($studentId);
        
        require_once '../src/Views/student/downloads.php';
    }
    
    public function filterMaterials() {
        $studentId = $this->getStudentId();
        $tutorId = isset($_GET['tutor_id']) && $_GET['tutor_id'] !== '' ? $_GET['tutor_id'] : null;
        $subjectId = isset($_GET['subject_id']) && $_GET['subject_id'] !== '' ? $_GET['subject_id'] : null;
    
        $materials = $this->studyMaterialModel->getFilteredMaterials(
            $studentId,
            $tutorId,
            $subjectId
        );
    
        if (empty($materials)) {
            echo '<div class="no-materials">No materials found matching your criteria.</div>';
            return;
        }
    
        echo '<ul class="materials-list">';
        foreach ($materials as $material) {
            echo '<li class="material-item">
                    <span class="material-description">' . htmlspecialchars($material['material_description']) . '</span>
                    <a href="/student-downloads/download?material_id=' . htmlspecialchars($material['material_id']) . '" 
                       class="download-button">Download</a>
                  </li>';
        }
        echo '</ul>';
    }


    public function downloadMaterial() {
        $studentId = $this->getStudentId();
        $materialId = isset($_GET['material_id']) ? intval($_GET['material_id']) : null;
    
        if (!$materialId) {
            http_response_code(400);
            echo "Invalid material ID.";
            return;
        }
    
        
        $hasAccess = $this->studyMaterialModel->canStudentAccessMaterial($studentId, $materialId);
        if (!$hasAccess) {
            http_response_code(403);
            echo "You do not have access to this material.";
            return;
        }
    
        
        $material = $this->studyMaterialModel->getMaterialById($materialId);
        if (!$material) {
            http_response_code(404);
            echo "Material not found.";
            return;
        }
    
        
        $filePath = __DIR__ . '/../../../public/uploads/tutor_study_materials/' . $material['material_path'];
        if (!file_exists($filePath)) {
            http_response_code(404);
            echo "File not found: " . htmlspecialchars($filePath);
            return;
        }
    
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}