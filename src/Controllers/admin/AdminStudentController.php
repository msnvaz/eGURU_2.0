<?php
namespace App\Controllers\admin;
use App\Models\admin\adminStudentModel;

class adminStudentController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); // Redirect to login page if not logged in
            exit();
        } 
        $this->model = new adminStudentModel();
    }

    public function searchStudents() {
        $studentModel = new adminStudentModel();
        $grades = $studentModel->getStudentGrades();
        
        // Get search parameters
        $searchTerm = $_POST['search_term'] ?? '';
        $grade = $_POST['grade'] ?? '';
        $startDate = $_POST['start_date'] ?? '';
        $endDate = $_POST['end_date'] ?? '';
        $onlineStatus = $_POST['online_status'] ?? '';
        
        // Determine if we're looking for active or deleted students
        // Check if we're on the deleted students page
        $currentUrl = $_SERVER['REQUEST_URI'];
        $status = (strpos($currentUrl, 'admin-deleted-students') !== false) ? 'unset' : 'set';
        
        // Search students
        $students = $studentModel->searchStudents(
            $searchTerm,
            $grade,
            $startDate,
            $endDate,
            $status,
            $onlineStatus
        );
        
        // Set variable for view to distinguish between active and deleted students
        if ($status == 'unset') {
            $deletedStudents = $students;
        }
        
        // Load the view
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }
    
    public function showAllStudents() {
        $studentModel = new adminStudentModel();
        $grades = $studentModel->getStudentGrades();
        $students = [];
        
        // Handle search and filter
        if (isset($_POST['search']) || isset($_GET['search'])) {
            // Get filter values from POST or GET (for pagination)
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            $onlineStatus = $_POST['online_status'] ?? $_GET['online_status'] ?? '';
            
            // Get filtered students
            $students = $studentModel->searchStudents(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'set',  // Active students
                $onlineStatus
            );
        } else {
            // Get all active students if no search/filter
            $students = $studentModel->getAllStudents('set');
        }
        
        // Load the view
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    public function showDeletedStudents() {
        $studentModel = new adminStudentModel();
        $grades = $studentModel->getStudentGrades();
        $deletedStudents = [];
        
        // Handle search and filter for deleted students
        if (isset($_POST['search']) || isset($_GET['search'])) {
            // Get filter values
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            
            // Get filtered deleted students
            $deletedStudents = $studentModel->searchStudents(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'unset'  // Deleted students
            );
        } else {
            // Get all deleted students if no search/filter
            $deletedStudents = $studentModel->getDeletedStudents();
        }
        
        // Load the view
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    public function showBlockedStudents() {
        $studentModel = new adminStudentModel();
        $grades = $studentModel->getStudentGrades();
        $blockedStudents = [];
        
        // Handle search and filter for blocked students
        if (isset($_POST['search']) || isset($_GET['search'])) {
            // Get filter values
            $searchTerm = $_POST['search_term'] ?? $_GET['search_term'] ?? '';
            $grade = $_POST['grade'] ?? $_GET['grade'] ?? '';
            $startDate = $_POST['start_date'] ?? $_GET['start_date'] ?? '';
            $endDate = $_POST['end_date'] ?? $_GET['end_date'] ?? '';
            
            // Get filtered blocked students
            $blockedStudents = $studentModel->searchStudents(
                $searchTerm,
                $grade,
                $startDate,
                $endDate,
                'blocked'  // Blocked students
            );
        } else {
            // Get all blocked students if no search/filter
            $blockedStudents = $studentModel->getBlockedStudents();
        }
        
        // Load the view
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    // Rest of your existing methods
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
        
        // Initialize empty data array
        $data = [];
        
        // Add debugging at the start
        error_log("Updating student profile for ID: " . $studentId);
        error_log("POST data: " . print_r($_POST, true));
        error_log("FILES data: " . print_r($_FILES, true));
        
        // Add only fields that are provided and not empty
        if (!empty($_POST['student_first_name'])) {
            $data['student_first_name'] = htmlspecialchars($_POST['student_first_name']);
        }
        
        if (!empty($_POST['student_last_name'])) {
            $data['student_last_name'] = htmlspecialchars($_POST['student_last_name']);
        }
        
        if (!empty($_POST['student_email'])) {
            $student_email = filter_var($_POST['student_email'], FILTER_SANITIZE_EMAIL);
            // Check if student_email already exists for another student
            if ($studentModel->emailExists($student_email, $studentId)) {
                error_log("Duplicate student_email detected: " . $student_email);
                header("Location: /admin-student-profile/$studentId?error=duplicate_email");
                exit();
            }
            $data['student_email'] = $student_email;
        }
        
        if (!empty($_POST['student_DOB'])) {
            try {
                // Ensure `DateTime` uses the global namespace
                $dob = new \DateTime(htmlspecialchars($_POST['student_DOB']));
                $today = new \DateTime();
                
                // Calculate age
                $age = $today->diff($dob)->y;
        
                // Validate minimum age of 6 years
                if ($age < 6) {
                    error_log("Invalid date of birth - student too young: " . $_POST['student_DOB']);
                    header("Location: /admin-student-profile/" . urlencode($studentId) . "?error=invalid_age");
                    exit();
                }
        
                // If valid, store the sanitized date
                $data['student_DOB'] = $dob->format('Y-m-d'); // Standard format for DB storage
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
    
        // Handle profile photo upload if provided
        if (isset($_FILES['profile_photo']) && !empty($_FILES['profile_photo']['name']) && $_FILES['profile_photo']['error'] == 0) {
            $uploadDir = __DIR__ . '/../../../public/uploads/Student_Profiles/';
            
            // Ensure upload directory exists
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
        
        // Log the data after all fields have been processed
        error_log("Data array before update: " . print_r($data, true));
        
        // If no fields were provided, return error
        if (empty($data)) {
            error_log("No data provided for update");
            header("Location: /admin-student-profile/$studentId?error=1");
            exit();
        }
    
        // Update student profile
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
        
        // Check if the student exists
        $student = $studentModel->getStudentProfile($studentId);
        if (!$student) {
            header("Location: /admin-students?error=Student not found");
            exit();
        }
    
        // Attempt deletion
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
        
        // Check if the student exists
        $student = $studentModel->getStudentProfile($studentId);
        if (!$student) {
            header("Location: /admin-students?error=Student not found");
            exit();
        }
    
        // Attempt restoration
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
        
        // Check if the student exists
        $student = $studentModel->getStudentProfile($studentId);
        if (!$student) {
            header("Location: /admin-students?error=Student not found");
            exit();
        }
    
        // Attempt to block the student
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
        
        // Check if the student exists
        $student = $studentModel->getStudentProfile($studentId);
        if (!$student) {
            header("Location: /admin-students?error=Student not found");
            exit();
        }
    
        // Attempt to unblock the student
        $unblocked = $studentModel->updateStudentStatus($studentId, 'set');
        if ($unblocked) {
            header("Location: /admin-student-profile/$studentId?success=Student profile unblocked");
        } else {
            header("Location: /admin-student-profile/$studentId?error=Failed to unblock student");
        }
        exit();
    }
}