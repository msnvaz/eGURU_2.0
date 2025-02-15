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
        
        // Initialize empty data array
        $data = [];
        
        // Add only fields that are provided and not empty
        if (!empty($_POST['firstname'])) {
            $data['firstname'] = htmlspecialchars($_POST['firstname']);
        }
        if (!empty($_POST['lastname'])) {
            $data['lastname'] = htmlspecialchars($_POST['lastname']);
        }
        if (!empty($_POST['email'])) {
            $data['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        }
        if (!empty($_POST['phonenumber'])) {
            $data['phonenumber'] = htmlspecialchars($_POST['phonenumber']);
        }
        if (!empty($_POST['dateofbirth'])) {
            $data['dateofbirth'] = htmlspecialchars($_POST['dateofbirth']);
        }
        if (!empty($_POST['grade'])) {
            $data['grade'] = htmlspecialchars($_POST['grade']);
        }
    
        // Handle profile photo upload if provided
        if (!empty($_FILES['profile_photo']['name'])) {
            $uploadDir = __DIR__ . '/../../../public/uploads/Student_Profiles/';
            
            // Ensure upload directory exists
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileName = time() . '_' . basename($_FILES['profile_photo']['name']);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadFile)) {
                $data['profile_photo'] = $fileName;
            } else {
                error_log("Failed to upload file to: " . $uploadFile);
            }
        }
        
        // If no fields were provided, return error
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

    }
?>
