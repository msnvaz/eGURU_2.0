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
            // Prepare the SQL statement
            $sql = "SELECT * FROM admin WHERE username = :username AND password = :password";
            $stmt = $this->conn->prepare($sql);
            
            // Bind parameters using named placeholders
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            // Check if the user exists
            return $stmt->rowCount() > 0;
        } catch (\PDOException $e) {
            error_log("Database error during login: " . $e->getMessage());
            // Attempt to reconnect if connection was lost
            if (strpos($e->getMessage(), 'MySQL server has gone away') !== false) {
                $this->connectWithRetry();
                return $this->login($username, $password); // Retry the login
            }
            return false;
        }
    }
}