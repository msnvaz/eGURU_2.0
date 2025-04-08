<?php
namespace App\Models\admin;

use App\Config\Database;
use PDO;
use PDOException;

class adminSettingsModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    // Fetch all sessions with detailed information
    public function getAdminSettings() {
        $settings = [];
        
        try {
            // Get student registration setting
            $sql = "SELECT * FROM admin_settings WHERE admin_setting_name = 'student_registration'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $studentRegistration = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($studentRegistration) {
                $settings['student_registration'] = $studentRegistration;
            }
            
            // Get tutor registration setting
            $sql = "SELECT * FROM admin_settings WHERE admin_setting_name = 'tutor_registration'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $tutorRegistration = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($tutorRegistration) {
                $settings['tutor_registration'] = $tutorRegistration;
            }
            
            //get platfrom fee setting
            $sql = "SELECT * FROM admin_settings WHERE admin_setting_name = 'platform_fee'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $platformFee = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($platformFee) {
                $settings['platform_fee'] = $platformFee;
            }
            
            error_log('Model: getAdminSettings fetched ' . count($settings) . ' settings.');
            return $settings;
            
        } catch (PDOException $e) {
            error_log('Error fetching settings: ' . $e->getMessage());
            return [];
        }
    }

    // Update a specific admin setting
    public function updateAdminSetting($adminSettingName, $value) {
        try {
            $sql = "UPDATE admin_settings SET admin_setting_value = :value WHERE admin_setting_name = :adminSettingName";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':value', $value, PDO::PARAM_INT);
            $stmt->bindParam(':adminSettingName', $adminSettingName, PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                error_log('Model: updateAdminSetting updated ' . $adminSettingName . ' to ' . $value);
                return true;
            } else {
                error_log('Model: updateAdminSetting no changes made for ' . $adminSettingName);
                return false;
            }
            
        } catch (PDOException $e) {
            error_log('Error updating setting: ' . $e->getMessage());
            return false;
        }
    }
}