<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorStudyMaterialModel;

class TutorStudyMaterialsController {
    private $model;

    public function __construct() {
        $this->model = new TutorStudyMaterialModel();
    }

    
    public function showStudyMaterialsPage() {
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        $materials = [];

        if (isset($_SESSION['tutor_id'])) {
            $tutorId = $_SESSION['tutor_id'];
            $materials = $this->model->getAllStudyMaterials($tutorId);
            $subjects = $this->model->getAllSubjects();
        }

        require_once __DIR__ . '/../../Views/tutor/study_materials.php';
    }

    
    public function uploadStudyMaterial() {
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['material']) && isset($_POST['description']) && isset($_POST['subject_id']) && isset($_POST['grade'])) {
                $uploadDir = './uploads/tutor_study_materials/';
                $fileName = basename($_FILES['material']['name']);
                $uploadPath = $uploadDir . $fileName;
        
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
        
                if (move_uploaded_file($_FILES['material']['tmp_name'], $uploadPath)) {
                    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
                    $subjectId = $_POST['subject_id'];
                    $grade = $_POST['grade'];
        
                    if (isset($_SESSION['tutor_id'])) {
                        $tutorId = $_SESSION['tutor_id'];
        
                        
                        $this->model->addStudyMaterial($fileName, $description, $tutorId, $subjectId, $grade);
                    }
        
                    header('Location: /tutor-uploads?success=Upload Successful');
                    exit();
                } else {
                    echo "Failed to upload the file. Please try again.";
                }
            } else {
                echo "Please fill all fields and select a file.";
            }
        }
        
    }

    public function deleteStudyMaterial() {
        if (isset($_POST['id'])) {
            $this->model->deleteStudyMaterialById($_POST['id']);
            header("Location: /tutor-uploads?success=Delete Successful");
        }
    }

    public function updateStudyMaterial() {
        if (isset($_POST['id']) && isset($_POST['description'])) {
            $this->model->updateStudyMaterial($_POST['id'], $_POST['description'], $_POST['grade'], $_POST['subject_id']);
            header("Location: /tutor-uploads?success=Update Successful");
        }
    }
}
