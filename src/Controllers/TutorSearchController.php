<?php

namespace App\Controllers;

use App\Models\TutorSearchModel;

class TutorSearchController
{
    public function search()
    {
        $filters = [
            'grade' => $_GET['grade'] ?? null,
            'subject' => $_GET['subject'] ?? null,
            'level' => $_GET['level'] ?? null,
            'rating' => $_GET['rating'] ?? null,
            'session_count' => $_GET['session_count'] ?? null,
        ];

        $model = new TutorSearchModel();
        $tutors = $model->getFilteredTutors($filters);

        $this->render('tutorpreview', ['tutors' => $tutors]);
    }

    private function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . "/../Views/{$view}.php";
    }
}
