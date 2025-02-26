<?php
    namespace App\Controllers\admin;
    use App\Models\admin\adminStudentModel;

    class adminStudentController{
        private $model;

        public function __construct(){
            if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
                header('Location: /admin-login'); // Redirect to login page if not logged in
                exit();
            } 
            $this->model = new adminStudentModel();
        }

        public function showAllStudents(){
            $studentModel = new adminStudentModel();
            $students = $studentModel->getAllStudents();  // Get all students from the mode
            //have to add search
            require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
        }

        public function searchStudents(){
            $studentModel = new adminStudentModel();
            $students = $studentModel->getAllStudents();  // Get all students from the mode
            //have to add search
            require_once __DIR__ . '/../../Views/admin/AdminStudents.php';
        }

    public function showStudentProfile($studentId){
        $studentModel = new adminStudentModel();
        $student = $studentModel->getStudentProfile($studentId);  // Get student profile from the model
        require_once __DIR__ . '/../../Views/admin/AdminStudentProfile.php';
    }

    public function editStudentProfile($studentId){
        $studentModel = new adminStudentModel();
        $studentData = $studentModel->getStudentProfile($studentId);  // Changed variable name to match view
        require_once __DIR__ . '/../../Views/admin/AdminStudentProfileEdit.php';
    }

    public function updateStudentProfile($studentId){
        $studentModel = new adminStudentModel();
        
        // Add debugging
        error_log("Updating student profile for ID: " . $studentId);
        error_log("POST data: " . print_r($_POST, true));
        error_log("FILES data: " . print_r($_FILES, true));
        error_log("Data being updated: " . json_encode($data));

        
        // Initialize empty data array
        $data = [];
        
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
            } catch (Exception $e) {
                error_log("Date of birth validation error: " . $e->getMessage());
                header("Location: /admin-student-profile/" . urlencode($studentId) . "?error=invalid_dob");
                exit();
            }
        }
        
        if (!empty($_POST['student_phonenumber'])) {

            $data['student_phonenumber'] = htmlspecialchars($_POST['student_phonenumber']);
        }
        if (!empty($_POST['student_DOB'])) {
            $data['student_DOB'] = htmlspecialchars($_POST['student_DOB']);
        }
        if (!empty($_POST['student_phonenumber'])) {
            $data['student_phonenumber'] = htmlspecialchars($_POST['student_phonenumber']);
        }
    
        // Handle profile photo upload if provided
        if (!empty($_FILES['student_profile_photo']['name'])) {
            $uploadDir = __DIR__ . '/../../../public/uploads/Student_Profiles/';
            
            // Ensure upload directory exists
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['student_profile_photo']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['student_profile_photo']['tmp_name'], $uploadFile)) {
                $data['student_profile_photo'] = $fileName;
            } else {
                error_log("Failed to upload file to: " . $uploadFile);
            }
        }
        
        // If no fields were provided, return error
        error_log("No data provided for update");

        if (empty($data)) {
            error_log("No data provided for update");
            header("Location: /admin-student-profile/$studentId?error=1");  // Changed from /admin/student-profile/
            exit();
        }
    
        // Update student profile
        if ($studentModel->updateStudentProfile($studentId, $data)) {
            header("Location: /admin-student-profile/$studentId?success=1");  // Changed from /admin/student-profile/
            exit();
        } else {
            error_log("Failed to update student profile in database");
            header("Location: /admin-student-profile/$studentId?error=1");  // Changed from /admin/student-profile/
            exit();
        }
    }

    //delete student profile
    //set the status to unset
    public function deleteStudentProfile($studentId){
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
