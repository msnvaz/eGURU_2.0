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

    public function getAdminSettings() {
        $settings = [];
        
        try {
            $sql = "SELECT * FROM admin_settings";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $Settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($Settings as $setting) {
                $settings[$setting['admin_setting_name']] = $setting;
            }

            error_log('Model: getAdminSettings fetched ' . count($settings) . ' settings.');
            return $settings;
            
        } catch (PDOException $e) {
            error_log('Error fetching settings: ' . $e->getMessage());
            return [];
        }
    }

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