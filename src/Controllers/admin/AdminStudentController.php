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

    public function showAllStudents() {
        $studentModel = new adminStudentModel();
        $students = $studentModel->getAllStudents();  // Get all students from the model
        //have to add search
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    public function searchStudents() {
        $studentModel = new adminStudentModel();
        $students = $studentModel->getAllStudents();  // Get all students from the model
        //have to add search
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    public function showStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        $student = $studentModel->getStudentProfile($studentId);  // Get student profile from the model
        require_once __DIR__ . '/../../Views/admin/AdminStudentProfile.php';
    }

    public function editStudentProfile($studentId) {
        $studentModel = new adminStudentModel();
        $studentData = $studentModel->getStudentProfile($studentId);  // Changed variable name to match view
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
        // IMPORTANT: Changed from 'student_profile_photo' to 'profile_photo' to match the form field
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

    //delete student profile
    //set the status to unset
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

    // Show deleted students
    public function showDeletedStudents() {
        $studentModel = new adminStudentModel();
        $deletedStudents = $studentModel->getDeletedStudents();
        require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
    }

    // Restore student profile
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
}
?>