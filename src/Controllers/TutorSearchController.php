<?php

namespace App\Controllers;

use App\Models\TutorSearchModel;

class TutorSearchController
{
    public function index()
    {
        // Check if it's a POST request (form submitted)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $filters = [
                'grade' => $_POST['grade'] ?? null,
                'subject' => $_POST['subject'] ?? null,
                'level' => $_POST['level'] ?? null,
                'rating' => $_POST['rating'] ?? null,
                'session_count' => $_POST['session_count'] ?? null,
            ];

            $model = new TutorPreviewModel();
            $tutors = $model->getFilteredTutors($filters);

            // If you use a template view:
            include '../views/tutorsearch.php'; // Replace with your actual view path

            // Or, if you want to return as JSON for AJAX:
            // header('Content-Type: application/json');
            // echo json_encode($tutors);
        } else {
            // Load view with no filter initially
            include '../views/tutorsearch.php';
        }
    }
}
