<?php
namespace App\Controllers\student;

use App\Models\student\StudentReportModel;

class StudentReportController {
    private $model1;
    private $data;
    private $tutors;

    public function __construct() {
        $this->model1 = new StudentReportModel();
        $this->data = $this->model1->get_report();
        $this->tutors = $this->model1->get_tutors();
    }

    public function ShowReport() {
        $data = $this->data;
        $tutors = $this->tutors;
        include '../src/Views/student/report.php';
    }

    public function get_tutor_details() {
        if(isset($_POST['tutor_id'])) {
            $tutor_id = $_POST['tutor_id'];
            $details = $this->model1->get_tutor_details($tutor_id);
            echo json_encode($details);
            exit;
        }
    }

    public function save_report() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!isset($_SESSION['student_id'])) {
                die("Unauthorized access.");
            }

            $student_id = $_SESSION['student_id'];
            $tutor_id = isset($_POST['tutor_id']) ? intval($_POST['tutor_id']) : null;
            $issue_type = isset($_POST['issue_type']) ? trim($_POST['issue_type']) : null;
            $description = isset($_POST['description']) ? trim($_POST['description']) : null;

            if (!$tutor_id || !$issue_type || !$description) {
                die("All fields are required.");
            }

            $success = $this->model1->save_report($student_id, $tutor_id, $issue_type, $description);

            if ($success) {
                header("Location: /student-report");
                exit;
            } else {
                die("Error saving report.");
            }
        }
    }
}
