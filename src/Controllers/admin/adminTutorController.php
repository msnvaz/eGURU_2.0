<?php
namespace App\Controllers\admin;
use App\Models\admin\adminTutorModel;

class adminTutorController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login');
            exit();
        } 
        $this->model = new adminTutorModel();
    }

    public function showAllTutors() {
        $tutorModel = new adminTutorModel();
        $grades = $tutorModel->getTutorGrades();
        $tutors = [];
        
        if (isset($_POST['search']) || isset($_GET['search'])) {
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            $onlineStatus = $_POST['online_status'] ?? $_GET['online_status'] ?? '';
            
            $tutors = $tutorModel->searchTutors(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'set',
                $onlineStatus
            );
        } else {
            $tutors = $tutorModel->getAllTutors('set');
        }
        
        require_once __DIR__ . '/../../Views/admin/AdminTutors.php';
    }

    public function showDeletedTutors() {
        $tutorModel = new adminTutorModel();
        $grades = $tutorModel->getTutorGrades();
        $deletedTutors = [];
        
        if (isset($_POST['search']) || isset($_GET['search'])) {
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            
            $deletedTutors = $tutorModel->searchTutors(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'unset'
            );
        } else {
            $deletedTutors = $tutorModel->getDeletedTutors();
        }
        
        require_once __DIR__ . '/../../Views/admin/AdminTutors.php';
    }

    public function searchTutors() {
        $tutorModel = new adminTutorModel();
        $grades = $tutorModel->getTutorGrades();
        
        $searchTerm = $_POST['search_term'] ?? '';
        $grade = $_POST['grade'] ?? '';
        $startDate = $_POST['start_date'] ?? '';
        $endDate = $_POST['end_date'] ?? '';
        $onlineStatus = $_POST['online_status'] ?? '';
        
        $currentUrl = $_SERVER['REQUEST_URI'];
        $status = (strpos($currentUrl, 'admin-deleted-tutors') !== false) ? 'unset' : 'set';
        
        $tutors = $tutorModel->searchTutors(
            $searchTerm,
            $grade,
            $startDate,
            $endDate,
            $status,
            $onlineStatus
        );
        
        if ($status == 'unset') {
            $deletedTutors = $tutors;
        }
        
        require_once __DIR__ . '/../../Views/admin/AdminTutors.php';
    }
    
    public function showTutorProfile($tutorId) {
        $tutor = $this->model->getTutorProfile($tutorId);
        require_once __DIR__ . '/../../Views/admin/AdminTutorProfile.php';
    }

    public function editTutorProfile($tutorId) {
        $tutorData = $this->model->getTutorProfile($tutorId);
        require_once __DIR__ . '/../../Views/admin/AdminTutorProfileEdit.php';
    }

    public function updateTutorProfile($tutorId) {
        $data = [];
        
        if (!empty($_POST['tutor_first_name'])) {
            $data['tutor_first_name'] = htmlspecialchars($_POST['tutor_first_name']);
        }
        
        if (!empty($_POST['tutor_last_name'])) {
            $data['tutor_last_name'] = htmlspecialchars($_POST['tutor_last_name']);
        }
        
        if (!empty($_POST['tutor_email'])) {
            $tutor_email = filter_var($_POST['tutor_email'], FILTER_SANITIZE_EMAIL);
            if ($this->model->emailExists($tutor_email, $tutorId)) {
                header("Location: /admin-tutor-profile/$tutorId?error=duplicate_email");
                exit();
            }
            $data['tutor_email'] = $tutor_email;
        }
        
        if (!empty($_POST['tutor_DOB'])) {
            try {
                $dob = new \DateTime(htmlspecialchars($_POST['tutor_DOB']));
                $data['tutor_DOB'] = $dob->format('Y-m-d');
            } catch (\Exception $e) {
                error_log("Date of birth validation error: " . $e->getMessage());
                header("Location: /admin-tutor-profile/$tutorId?error=invalid_dob");
                exit();
            }
        }
        
        if (!empty($_POST['tutor_contact_number'])) {
            $data['tutor_contact_number'] = htmlspecialchars($_POST['tutor_contact_number']);
        }
        
        if (!empty($_POST['tutor_level_id'])) {
            $data['tutor_level_id'] = htmlspecialchars($_POST['tutor_level_id']);
        }
    
        if (isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo']['name']) && $_FILES['profile_photo']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../../public/images/tutor_uploads/tutor_profile_photos/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . '_' . basename($_FILES['profile_photo']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadFile)) {
                $data['tutor_profile_photo'] = $fileName;
            }
        }
        
        if ($this->model->updateTutorProfile($tutorId, $data)) {
            header("Location: /admin-tutor-profile/$tutorId?success=1");
        } else {
            header("Location: /admin-tutor-profile/$tutorId?error=1");
        }
        exit();
    }

    public function deleteTutorProfile($tutorId) {
        $tutor = $this->model->getTutorProfile($tutorId);
        if (!$tutor) {
            header("Location: /admin-tutors?error=Tutor not found");
            exit();
        }
    
        if ($this->model->deleteTutorProfile($tutorId)) {
            header("Location: /admin-tutors?success=Tutor profile deleted");
        } else {
            header("Location: /admin-tutors?error=Failed to delete tutor");
        }
        exit();
    }

    public function restoreTutorProfile($tutorId) {
        $tutor = $this->model->getTutorProfile($tutorId);
        if (!$tutor) {
            header("Location: /admin-tutors?error=Tutor not found");
            exit();
        }
    
        if ($this->model->restoreTutorProfile($tutorId)) {
            header("Location: /admin-tutors?success=Tutor profile restored");
        } else {
            header("Location: /admin-tutors?error=Failed to restore tutor");
        }
        exit();
    }

    public function showBlockedTutors() {
        $tutorModel = new adminTutorModel();
        $grades = $tutorModel->getTutorGrades();
        $blockedTutors = [];
        
        if (isset($_POST['search']) || isset($_GET['search'])) {
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            
            $blockedTutors = $tutorModel->searchTutors(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'blocked'
            );
        } else {
            $blockedTutors = $tutorModel->getBlockedTutors();
        }
        
        require_once __DIR__ . '/../../Views/admin/AdminTutors.php';
    }
    
    public function blockTutorProfile($tutorId) {
        $tutor = $this->model->getTutorProfile($tutorId);
        if (!$tutor) {
            header("Location: /admin-tutors?error=Tutor not found");
            exit();
        }
    
        if ($this->model->blockTutorProfile($tutorId)) {
            header("Location: /admin-tutors?success=Tutor profile blocked");
        } else {
            header("Location: /admin-tutors?error=Failed to block tutor");
        }
        exit();
    }
    
    public function unblockTutorProfile($tutorId) {
        $tutor = $this->model->getTutorProfile($tutorId);
        if (!$tutor) {
            header("Location: /admin-blocked-tutors?error=Tutor not found");
            exit();
        }
    
        if ($this->model->unblockTutorProfile($tutorId)) {
            header("Location: /admin-blocked-tutors?success=Tutor profile unblocked");
        } else {
            header("Location: /admin-blocked-tutors?error=Failed to unblock tutor");
        }
        exit();
    }
}