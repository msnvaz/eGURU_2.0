<?php
    namespace App\Controllers\admin;
    
    class adminSettingsController{
        private $model;

        public function __construct(){
            if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
                header('Location: /admin-login'); 
                exit();
            } 
        }

        public function showSettings(){
            $this->model = new \App\Models\admin\adminSettingsModel();
            $adminSettings = $this->model->getAdminSettings();
            
            $adminStudentRegistration = $adminSettings['student_registration'] ?? ['admin_setting_value' => false];
            $adminTutorRegistration = $adminSettings['tutor_registration'] ?? ['admin_setting_value' => false];
            $adminPlatformFee = $adminSettings['platform_fee'] ?? ['admin_setting_value' => 5];
            $default_duration = $adminSettings['default_duration'] ?? ['admin_setting_value' => 60];
            $booking_window = $adminSettings['booking_window'] ?? ['admin_setting_value' => 7];
            $cancellation_window = $adminSettings['cancellation_window'] ?? ['admin_setting_value' => 24];
            $noshow_penalty = $adminSettings['noshow_penalty'] ?? ['admin_setting_value' => 'none'];
            $email_notifications = $adminSettings['email_notifications'] ?? ['admin_setting_value' => true];
            $reminder_time = $adminSettings['reminder_time'] ?? ['admin_setting_value' => 24];
            $payout_schedule = $adminSettings['payout_schedule'] ?? ['admin_setting_value' => 7];
            $adminContentApproval = $adminSettings['content_approval'] ?? ['admin_setting_value' => true];
            $adminMaxFileSize = $adminSettings['max_file_size'] ?? ['admin_setting_value' => 10];
            $allowed_file_types = $adminSettings['allowed_file_types'] ?? ['admin_setting_value' => 'pdf,doc,image'];
            $theme = $adminSettings['theme'] ?? ['admin_setting_value' => 'light'];
            $custom_logo = $adminSettings['custom_logo'] ?? ['admin_setting_value' => ''];
            $video_platform = $adminSettings['video_platform'] ?? ['admin_setting_value' => 'zoom'];
            $calendar_integration = $adminSettings['calendar_integration'] ?? ['admin_setting_value' => 'none'];
            $require_2fa = $adminSettings['require_2fa'] ?? ['admin_setting_value' => false];
            $password_policy = $adminSettings['password_policy'] ?? ['admin_setting_value' => 'basic'];
            $session_timeout = $adminSettings['session_timeout'] ?? ['admin_setting_value' => 30];
                       
            require_once __DIR__ . '/../../Views/admin/AdminSettings.php';
        }

        public function updateSettings(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->model = new \App\Models\admin\adminSettingsModel();
                
                $tutorRegistration = isset($_POST['tutor_registration']) ? 1 : 0;
                $studentRegistration = isset($_POST['student_registration']) ? 1 : 0;
                $emailNotifications = isset($_POST['email_notifications']) ? 1 : 0;
                $contentApproval = isset($_POST['content_approval']) ? 1 : 0;
                
                $this->model->updateAdminSetting('tutor_registration', $tutorRegistration);
                $this->model->updateAdminSetting('student_registration', $studentRegistration);
                $this->model->updateAdminSetting('platform_fee', intval($_POST['platform_fee'] ?? 5));
                $this->model->updateAdminSetting('default_duration', intval($_POST['default_duration'] ?? 60));
                $this->model->updateAdminSetting('booking_window', intval($_POST['booking_window'] ?? 7));
                $this->model->updateAdminSetting('cancellation_window', intval($_POST['cancellation_window'] ?? 24));
                $this->model->updateAdminSetting('noshow_penalty', $_POST['noshow_penalty'] ?? 'none');
                $this->model->updateAdminSetting('email_notifications', $emailNotifications);
                $this->model->updateAdminSetting('reminder_time', intval($_POST['reminder_time'] ?? 24));
                $this->model->updateAdminSetting('payout_schedule', intval($_POST['payout_schedule'] ?? 7));
                $this->model->updateAdminSetting('content_approval', $contentApproval);
                $this->model->updateAdminSetting('max_file_size', intval($_POST['max_file_size'] ?? 10));
                
                if (isset($_POST['allowed_file_types']) && is_array($_POST['allowed_file_types'])) {
                    $allowedFileTypes = implode(',', $_POST['allowed_file_types']);
                    $this->model->updateAdminSetting('allowed_file_types', $allowedFileTypes);
                }
                
                $this->model->updateAdminSetting('theme', $_POST['theme'] ?? 'light');
                $this->model->updateAdminSetting('video_platform', $_POST['video_platform'] ?? 'zoom');
                $this->model->updateAdminSetting('calendar_integration', $_POST['calendar_integration'] ?? 'none');
                
                if (isset($_FILES['custom_logo']) && $_FILES['custom_logo']['error'] == 0) {
                    $uploadDir = __DIR__ . '/../../public/uploads/';
                    $fileName = 'logo_' . time() . '_' . $_FILES['custom_logo']['name'];
                    $filePath = $uploadDir . $fileName;
                    
                    if (!file_exists($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    if (move_uploaded_file($_FILES['custom_logo']['tmp_name'], $filePath)) {
                        $this->model->updateAdminSetting('custom_logo', '/uploads/' . $fileName);
                    }
                }
                
                $_SESSION['message'] = 'Settings updated successfully';
                header('Location: /admin-settings');
                exit();
            }
        }
    }
?>