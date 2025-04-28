<?php
namespace App\Controllers\admin;
use App\Models\admin\adminStudentModel;

class adminStudentController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); 
            exit();
        } 
        $this->model = new adminStudentModel();
    }

    public function searchStudents() {
        $studentModel = new adminStudentModel();
        $grades = $studentModel->getStudentGrades();
        
        $searchTerm = $_POST['search_term'] ?? '';
        $grade = $_POST['grade'] ?? '';
        $startDate = $_POST['start_date'] ?? '';
        $endDate = $_POST['end_date'] ?? '';
        $onlineStatus = $_POST['online_status'] ?? '';
        
        $currentUrl = $_SERVER['REQUEST_URI'];
        $status = (strpos($currentUrl, 'admin-deleted-students') !== false) ? 'unset' : 'set';
        
        $students = $studentModel->searchStudents(
            $searchTerm,
            $grade,
            $startDate,
            $endDate,
            $status,
            $onlineStatus
        );
        
        if ($status == 'unset') {
            $deletedStudents = $students;
        }
        
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }
    
    public function showAllStudents() {
        $studentModel = new adminStudentModel();
        $grades = $studentModel->getStudentGrades();
        $students = [];
        
        if (isset($_POST['search']) || isset($_GET['search'])) {
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            $onlineStatus = $_POST['online_status'] ?? $_GET['online_status'] ?? '';
            
            $students = $studentModel->searchStudents(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'set',  
                $onlineStatus
            );
        } else {
            $students = $studentModel->getAllStudents('set');
        }
        
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    public function showDeletedStudents() {
        $studentModel = new adminStudentModel();
        $grades = $studentModel->getStudentGrades();
        $deletedStudents = [];
        
        if (isset($_POST['search']) || isset($_GET['search'])) {
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            
            $deletedStudents = $studentModel->searchStudents(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'unset'  
            );
        } else {
            $deletedStudents = $studentModel->getDeletedStudents();
        }
        
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    public function showBlockedStudents() {
        $studentModel = new adminStudentModel();
        $grades = $studentModel->getStudentGrades();
        $blockedStudents = [];
        
        if (isset($_POST['search']) || isset($_GET['search'])) {
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            
            $blockedStudents = $studentModel->searchStudents(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'blocked' 
            );
        } else {
            $blockedStudents = $studentModel->getBlockedStudents();
        }
        
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    public function showStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        $student = $studentModel->getStudentProfile($studentId);
        require_once __DIR__ . '/../../Views/admin/AdminStudentProfile.php';
    }

    public function editStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        $studentData = $studentModel->getStudentProfile($studentId);
        require_once __DIR__ . '/../../Views/admin/AdminStudentProfileEdit.php';
    }

    public function updateStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        
        $data = [];
        
        error_log("Updating student profile for ID: " . $studentId);
        error_log("POST data: " . print_r($_POST, true));
        error_log("FILES data: " . print_r($_FILES, true));
        
        if (!empty($_POST['student_first_name'])) {
            $data['student_first_name'] = htmlspecialchars($_POST['student_first_name']);
        }
        
        if (!empty($_POST['student_last_name'])) {
            $data['student_last_name'] = htmlspecialchars($_POST['student_last_name']);
        }
        
        if (!empty($_POST['student_email'])) {
            $student_email = filter_var($_POST['student_email'], FILTER_SANITIZE_EMAIL);
            if ($studentModel->emailExists($student_email, $studentId)) {
                error_log("Duplicate student_email detected: " . $student_email);
                header("Location: /admin-student-profile/$studentId?error=duplicate_email");
                exit();
            }
            $data['student_email'] = $student_email;
        }
        
        if (!empty($_POST['student_DOB'])) {
            try {
                $dob = new \DateTime(htmlspecialchars($_POST['student_DOB']));
                $today = new \DateTime();
                
                $age = $today->diff($dob)->y;
        
                if ($age < 6) {
                    error_log("Invalid date of birth - student too young: " . $_POST['student_DOB']);
                    header("Location: /admin-student-profile/" . urlencode($studentId) . "?error=invalid_age");
                    exit();
                }
        
                $data['student_DOB'] = $dob->format('Y-m-d'); 
            } catch (\Exception $e) {
                error_log("Date of birth validation error: " . $e->getMessage());
                header("Location: /admin-student-profile/" . urlencode($studentId) . "?error=invalid_dob");
                exit();
            }
        }
        
        if (!empty($_POST['student_phonenumber'])) {
            $data['student_phonenumber'] = htmlspecialchars($_POST['student_phonenumber']);
        }
        
        if (!empty($_POST['student_grade'])) {
            $data['student_grade'] = htmlspecialchars($_POST['student_grade']);
        }
    
        if (isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo']['name']) && $_FILES['profile_photo']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../../public/images/student-uploads/profilePhotos/';
            
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['profile_photo']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            error_log("Attempting to upload file: " . $_FILES['profile_photo']['name'] . " to " . $uploadFile);
            
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadFile)) {
                $data['student_profile_photo'] = $fileName;
                error_log("File uploaded successfully: " . $fileName);
            } else {
                error_log("Failed to upload file. Error code: " . $_FILES['profile_photo']['error']);
            }
        }
        
        
        error_log("Data array before update: " . print_r($data, true));
        
        if (empty($data)) {
            error_log("No data provided for update");
            header("Location: /admin-student-profile/$studentId?error=1");
            exit();
        }
    
        if ($studentModel->updateStudentProfile($studentId, $data)) {
            error_log("Student profile updated successfully");
            header("Location: /admin-student-profile/$studentId?success=1");
            exit();
        } else {
            error_log("Failed to update student profile in database");
            header("Location: /admin-student-profile/$studentId?error=1");
            exit();
        }
    }

    public function deleteStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        
        $student = $studentModel->getStudentProfile($studentId);
        if (!$student) {
            header("Location: /admin-students?error=Student not found");
            exit();
        }
    
        $deleted = $studentModel->deleteStudentProfile($studentId);
        if ($deleted) {
            header("Location: /admin-students?success=Student profile deleted");
        } else {
            header("Location: /admin-students?error=Failed to delete student");
        }
        exit();
    }

    public function restoreStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        
        $student = $studentModel->getStudentProfile($studentId);
        if (!$student) {
            header("Location: /admin-students?error=Student not found");
            exit();
        }
    
        $restored = $studentModel->restoreStudentProfile($studentId);
        if ($restored) {
            header("Location: /admin-students?success=Student profile restored");
        } else {
            header("Location: /admin-students?error=Failed to restore student");
        }
        exit();
    }

    public function blockStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        
        $student = $studentModel->getStudentProfile($studentId);
        if (!$student) {
            header("Location: /admin-students?error=Student not found");
            exit();
        }
    
        $blocked = $studentModel->updateStudentStatus($studentId, 'blocked');
        if ($blocked) {
            header("Location: /admin-student-profile/$studentId?success=Student profile blocked");
        } else {
            header("Location: /admin-student-profile/$studentId?error=Failed to block student");
        }
        exit();
    }

    public function unblockStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        
        $student = $studentModel->getStudentProfile($studentId);
        if (!$student) {
            header("Location: /admin-students?error=Student not found");
            exit();
        }
    
        $unblocked = $studentModel->updateStudentStatus($studentId, 'set');
        if ($unblocked) {
            header("Location: /admin-student-profile/$studentId?success=Student profile unblocked");
        } else {
            header("Location: /admin-student-profile/$studentId?error=Failed to unblock student");
        }
        exit();
    }
}