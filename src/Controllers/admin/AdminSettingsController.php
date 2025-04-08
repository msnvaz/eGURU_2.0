<?php
    namespace App\Controllers\admin;
    
    class adminSettingsController{
        private $model;

        public function __construct(){
            if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
                header('Location: /admin-login'); // Redirect to login page if not logged in
                exit();
            } 
        }

        public function showSettings(){
            // Get current data from the model
            $this->model = new \App\Models\admin\adminSettingsModel();
            $adminSettings = $this->model->getAdminSettings();
            
            // Extract settings using the correct keys
            $adminStudentRegistration = $adminSettings['student_registration'] ?? ['admin_setting_value' => false];
            $adminTutorRegistration = $adminSettings['tutor_registration'] ?? ['admin_setting_value' => false];
            $adminPlatformFee = $adminSettings['platform_fee'] ?? ['admin_setting_value' => 5];            
            
            // Include the view file
            require_once __DIR__ . '/../../Views/admin/AdminSettings.php';
        }

        public function updateSettings(){
            // Check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $tutorRegistration = isset($_POST['tutor_registration']) ? true : false;
                $studentRegistration = isset($_POST['student_registration']) ? true : false;
                
                // Update settings in the model
                $this->model = new \App\Models\admin\adminSettingsModel();
                $this->model->updateAdminSetting('tutor_registration', $tutorRegistration);
                $this->model->updateAdminSetting('student_registration', $studentRegistration);
                
                // Redirect back to the settings page
                header('Location: /admin-settings');
                exit();
            }
        }
    }
?>
