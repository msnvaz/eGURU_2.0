<?php

namespace App\Controllers\student;

use App\Models\student\StudentTutorRequestFormModel;

class StudentTutorRequestFormController {
    private $model;

    public function __construct() {
        $this->model = new StudentTutorRequestFormModel();
    }

    /**
     * Display the tutor request form page.
     */
    public function showTutorRequestForm() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        $student_id = $_SESSION['student_id'];
        $tutor_id = $_GET['tutor_id'] ?? null;

        // Fetch tutor details
        $request = $this->model->getrequest($tutor_id);

        // Pass tutor details to the view
        include '../src/Views/student/tutor_request_form.php';
}