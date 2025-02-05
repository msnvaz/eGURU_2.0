<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;

class AdminLoginModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        // Test the connection
        if (!$this->conn) {
            die("Database connection failed.");
        }
    }

    // Check if username and password are correct
    public function login($username, $password) {
        // Prepare the SQL statement
        $sql = "SELECT * FROM admin WHERE username = :username AND password = :password";
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters using named placeholders
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        // Check if the user exists
        if ($stmt->rowCount() > 0) {
            $_SESSION['admin_logged_in'] = true; // Set session variable
            return true; // Login successful
        }

        return false; // Invalid username or password
    }
}