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
                // Set connection timeout to prevent premature disconnection
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

    // Check if username and password are correct
    public function login($username, $password) {
        try {
            // Check local session first
            if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                return ['status' => 'already_logged_in_locally'];
            }
            
            // Hash the password with SHA1
            $hashedPassword = sha1($password);
                
            // Prepare the SQL statement to check credentials
            $sql = "SELECT admin_id, admin_login_status FROM admin WHERE username = :username AND password = :password";
            $stmt = $this->conn->prepare($sql);
            
            // Bind parameters using named placeholders
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            // Check if the user exists
            if ($stmt->rowCount() > 0) {
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Check if already logged in elsewhere
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
    
    // Update login status in the database
    public function updateLoginStatus($adminId, $status) {
        try {
            $sql = "UPDATE admin SET admin_login_status = :status WHERE admin_id = :admin_id";
            $stmt = $this->conn->prepare($sql);
            
            $statusValue = $status ? 1 : 0;
            $stmt->bindParam(':status', $statusValue, PDO::PARAM_INT);
            $stmt->bindParam(':admin_id', $adminId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Database error updating login status: " . $e->getMessage());
            return false;
        }
    }
    
    // Force logout previous session
    public function forceLogout($adminId) {
        return $this->updateLoginStatus($adminId, false);
    }
    
    // Update password with SHA1 hashing
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