<?php

namespace App\Controllers;

use App\Models\SubjectPageModel;
use App\Controller;

class SubjectPageController extends Controller {
    private $model;

    public function __construct() {
        $this->model = new SubjectPageModel();
    }

    public function showSubjectPage() {
        try {
            $subject = $_GET['subject'] ?? '';

            if (empty($subject)) {
                return $this->handleMissingView("Subject not specified.");
            }

            $subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');

            $gradeFilter = $_GET['tutor_level'] ?? ''; 
            $availableOnly = isset($_GET['available']) && $_GET['available'] === '1';

            $tutors = $this->model->getTutorsBySubject($subject, $gradeFilter, $availableOnly);
            $tutorLevels = $this->model->getTutorLevelsBySubject($subject);

            error_log("Filtering tutors for subject: $subject, grade: $gradeFilter, available: " . ($availableOnly ? 'true' : 'false'));

            foreach ($tutors as &$tutor) {
                // Convert hour_fees to tutor_pay_per_hour with formatting
                $tutor['tutor_pay_per_hour'] = isset($tutor['tutor_pay_per_hour'])
                    ? number_format($tutor['tutor_pay_per_hour'], 2)
                    : 'N/A';

                // Average rating fallback
                $tutor['average_rating'] = isset($tutor['avg_rating']) && $tutor['avg_rating'] !== null
                    ? round($tutor['avg_rating'], 1)
                    : 'Not rated yet';
            }

            $viewData = [
                'subject' => $subject,
                'tutors' => $tutors,
                'tutorLevels' => $tutorLevels,
                'gradeFilter' => $gradeFilter,
                'availableOnly' => $availableOnly
            ];

            return $this->loadView('subjectpage', $viewData);
        } catch (\Exception $e) {
            error_log("Controller Error: " . $e->getMessage());
            return $this->handleMissingView("An error occurred while loading the page.");
        }
    }

    private function loadView($viewName, $data = []) {
        extract($data);
        $viewPath = __DIR__ . "/../Views/$viewName.php";

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            error_log("View not found: " . $viewPath);
            return $this->handleMissingView("Requested view is missing.");
        }
    }

    private function handleMissingView($message) {
        $errorViewPath = __DIR__ . "/../Views/error.php";

        if (file_exists($errorViewPath)) {
            return $this->loadView('error', ['message' => $message]);
        } else {
            die("<h2>Error</h2><p>$message</p>");
        }
    }
}
