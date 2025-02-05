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
            require_once __DIR__ . '/../../Views/admin/AdminSettings.php';
        }
    }
?>
