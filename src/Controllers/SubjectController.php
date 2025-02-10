<?php

namespace App\Controllers;
use App\Models\PublicSubjectsModel;
use App\Controller;

class SubjectController extends Controller{

    public function showSubjectPage() {
        $subjectModel = new PublicSubjectsModel();
        $tutors = $subjectModel->getSubjects();  // Get all subjects from the model
        // Load the view
        // require_once __DIR__ . '/../Views/subjectpage.php';
    }
}