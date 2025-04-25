<?php

namespace App\Controllers;

use App\Models\TutorSearchModel;

class TutorSearchController
{
    public function showSearchForm()
    {
        $filters = [
            'grade'   => $_GET['grade'] ?? null,
            'subject' => $_GET['subject'] ?? null,
            'level'   => $_GET['level'] ?? null,
        ];

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

    public function search()
    {
        $query = http_build_query([
            'grade'   => $_POST['grade'] ?? null,
            'subject' => $_POST['subject'] ?? null,
            'level'   => $_POST['level'] ?? null,
        ]);

        header("Location: /tutor/search?$query");
        exit;
    }

    private function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . "/../Views/tutorsearchresult.php";
    }
}
