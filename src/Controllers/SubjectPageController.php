<?php

namespace App\Controllers;

use App\Models\SubjectPageModel;
use App\Controller;

class SubjectPageController extends Controller {
    private $model;
    private $uploadPath = 'public/images/tutor_profile/';
    private $defaultImage = 'public/images/tutor_profile/default_image.jpeg';

    public function __construct() {
        $this->model = new SubjectPageModel();
    }

    public function showSubjectPage() {
        try {
            // Get subject dynamically from URL
            $subject = $_GET['subject'] ?? '';
            
            // If subject is empty, redirect to a default page or display a message
            if (empty($subject)) {
                return $this->handleMissingView("Subject not specified.");
            }

            // Sanitize subject to avoid invalid values
            $subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');

            // Filters
            $gradeFilter = $_GET['tutor_level'] ?? ''; 
            $availableOnly = isset($_GET['available']) && $_GET['available'] === '1'; // Ensure correct boolean check

            // Fetch data from model
            $tutors = $this->model->getTutorsBySubject($subject, $gradeFilter, $availableOnly);
            $tutorLevels = $this->model->getTutorLevelsBySubject($subject);

            // Debugging Logs
            error_log("Filtering tutors for subject: $subject, grade: $gradeFilter, available: " . ($availableOnly ? 'true' : 'false'));

            // Process profile images
            foreach ($tutors as &$tutor) {
                $tutor['profile_image'] = $this->getProfileImagePath($tutor['profile_image']);
            }

            // Pass data to view
            $viewData = [
                'subject' => $subject,
                'tutors' => $tutors,
                'tutorLevels' => $tutorLevels,
                'gradeFilter' => $gradeFilter,
                'availableOnly' => $availableOnly
            ];

            // Load the subject page view
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
        // Check if 'error.php' view exists before loading it
        $errorViewPath = __DIR__ . "/../Views/error.php";
        
        if (file_exists($errorViewPath)) {
            return $this->loadView('error', ['message' => $message]);
        } else {
            // Fallback if error view doesn't exist
            die("<h2>Error</h2><p>$message</p>");
        }
    }

    private function getProfileImagePath($profileImage) {
        if (empty($profileImage)) {
            return '/' . $this->defaultImage;
        }
    
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . '/eGURU_2.0/' . $this->uploadPath . basename($profileImage);
    
        // Debugging
        error_log("Checking file existence: " . $fullPath);
    
        if (file_exists($fullPath)) {
            return '/eGURU_2.0/' . $this->uploadPath . basename($profileImage);
        }
    
        return '/eGURU_2.0/' . $this->defaultImage;
    }
}
