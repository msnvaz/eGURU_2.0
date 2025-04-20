<?php

namespace App\Controllers;

use App\Models\TutorSearchModel;

class TutorSearchController
{
    // Handles GET requests to show the search form and display filtered results (if any)
    public function showSearchForm()
    {
        $filters = [
            'grade'         => $_GET['grade'] ?? null,
            'subject'       => $_GET['subject'] ?? null,
            'level'         => $_GET['level'] ?? null,
            'rating'        => $_GET['rating'] ?? null,
            'session_count' => $_GET['session_count'] ?? null,
        ];

        // Remove empty filters (null or empty string)
        $filters = array_filter($filters, fn($value) => $value !== null && $value !== '');

        $tutors = [];
        $searchPerformed = false;

        if (!empty($filters)) {
            $model = new TutorSearchModel();
            $tutors = $model->getFilteredTutors($filters);
            $searchPerformed = true;
        }

        $this->render('tutorsearch', [
            'tutors' => $tutors,
            'searchPerformed' => $searchPerformed,
        ]);
    }

    // Handles POST form submissions and redirects as GET request with query parameters
    public function search()
    {
        $query = http_build_query([
            'grade'         => $_POST['grade'] ?? null,
            'subject'       => $_POST['subject'] ?? null,
            'level'         => $_POST['level'] ?? null,
            'rating'        => $_POST['rating'] ?? null,
            'session_count' => $_POST['session_count'] ?? null,
        ]);

        // Redirect to search form with query string
        header("Location: /tutor/search?$query");
        exit;
    }

    // Helper method to render view
    private function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . "/../Views/{$view}.php";
    }
}
