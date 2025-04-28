<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;

class AdminLoginModel {
    private $conn;

    public function __construct() {
        $this->connectWithRetry();
    }

    private function connectWithRetry($maxAttempts = 3, $delay = 1) {
        $attempt = 0;
        $db = new Database();
        
        while ($attempt < $maxAttempts) {
            $this->conn = $db->connect();
            
            if ($this->conn) {
                $this->conn->setAttribute(PDO::ATTR_TIMEOUT, 30);
                return;
            }
            
            $attempt++;
            if ($attempt < $maxAttempts) {
                sleep($delay);
            }
        }
        
        throw new \RuntimeException("Failed to connect to database after $maxAttempts attempts");
    }

    public function login($username, $password) {
        try {
            if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                return ['status' => 'already_logged_in_locally'];
            }
            
            $hashedPassword = sha1($password);
                
            $sql = "SELECT admin_id, admin_login_status FROM admin WHERE username = :username AND password = :password";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($admin['admin_login_status'] == 1) {
                    return ['status' => 'already_logged_in_elsewhere', 'admin_id' => $admin['admin_id']];
                }
                
                return ['status' => 'success', 'admin_id' => $admin['admin_id']];
            }
            
            return ['status' => 'invalid_credentials'];
            
        } catch (\PDOException $e) {
            error_log("Database error during login: " . $e->getMessage());
            // Attempt to reconnect if connection was lost
            if (strpos($e->getMessage(), 'MySQL server has gone away') !== false) {
                $this->connectWithRetry();
                return $this->login($username, $password); // Retry the login
            }
            return ['status' => 'database_error'];
        }
    }
    
    public function updateLoginStatus($adminId, $status) {
        try {
            if (!$this->conn) {
                $this->connectWithRetry();
            }
            
            error_log("Updating admin login status for ID: $adminId to " . ($status ? '1' : '0'));
            
            $sql = "UPDATE admin SET admin_login_status = :status WHERE admin_id = :admin_id";
            $stmt = $this->conn->prepare($sql);
            
            $statusValue = $status ? 1 : 0;
            $stmt->bindParam(':status', $statusValue, PDO::PARAM_INT);
            $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
            
            $result = $stmt->execute();
            
            $rowCount = $stmt->rowCount();
            error_log("Rows affected by login status update: $rowCount");
            
            if ($rowCount === 0) {
                error_log("Warning: No rows affected when updating login status for admin_id: $adminId");
                $checkSql = "SELECT COUNT(*) as count FROM admin WHERE admin_id = :admin_id";
                $checkStmt = $this->conn->prepare($checkSql);
                $checkStmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
                $checkStmt->execute();
                $exists = $checkStmt->fetch(PDO::FETCH_ASSOC)['count'] > 0;
                error_log("Admin ID $adminId exists in database: " . ($exists ? 'Yes' : 'No'));
            }
            
            return $result;
        } catch (\PDOException $e) {
            error_log("Database error updating login status: " . $e->getMessage());
            if (strpos($e->getMessage(), 'MySQL server has gone away') !== false) {
                $this->connectWithRetry();
                return $this->updateLoginStatus($adminId, $status); // Retry
            }
            return false;
        }
    }
    
    public function forceLogout($adminId) {
        return $this->updateLoginStatus($adminId, false);
    }
    
    public function updatePassword($adminId, $newPassword) {
        try {
            $hashedPassword = sha1($newPassword);
            
            $sql = "UPDATE admin SET password = :password WHERE admin_id = :admin_id";
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Database error updating password: " . $e->getMessage());
            return false;
        }
    }
}