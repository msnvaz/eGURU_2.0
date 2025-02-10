<?php

namespace App\Controllers\student;

use App\Models\student\StudyMaterialModel;
class StudentDownloadsController{
    
    private $model;

    public function __construct() {
        //$this->model = new StudyMaterialModel();
    }

    public function ShowDownloads() {
        $this->loadView();
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $grade = isset($_POST['grade']) ? $_POST['grade'] : '';
            $subject = isset($_POST['subject']) ? $_POST['subject'] : '';

            if (!empty($grade) && !empty($subject)) {
                $materials = $this->model->getMaterials($grade, $subject);
                $this->loadView($materials, $grade, $subject);
            } else {
                $this->loadView([], $grade, $subject, "Please select both grade and subject.");
            }
        } else {
            //$this->loadView();
        }
    }

    private function loadView($materials = [], $grade = '', $subject = '', $error = '') {
        include '../src/Views/student/downloads.php';
    }
}

$controller = new StudentDownloadsController();
$controller->handleRequest();
?>
