<?php

namespace App\Models;

use App\Config\Database;
use PDO;
use PDOException;

class VisitorQueryModel {
    private $conn;

    public function __construct() {
        try {
            $db = new Database();
            $this->conn = $db->connect();
        } catch (PDOException $e) {
            error_log("Database connection error: " . $e->getMessage());
            throw new \Exception("Unable to connect to the database");
        }
    }

    public function createVisitorQuery($first_name, $last_name, $email, $district, $message) {
        try {
            $sql = "INSERT INTO visitor_query (first_name, last_name, email, district, message, created_at) 
                    VALUES (:first_name, :last_name, :email, :district, :message, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':district', $district);
            $stmt->bindParam(':message', $message);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Create visitor query error: " . $e->getMessage());
            return false;
        }
    }
}
