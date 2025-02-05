<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;

class FeeRequestModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

    // Fetch fee requests
    public function getFeeRequests($limit = 5) {
        $sql = "SELECT * FROM fee_request 
                ORDER BY status='Pending' DESC, date DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        
        if (!$stmt->execute()) {
            // Handle execution error
            die("Error executing query: " . implode(", ", $stmt->errorInfo()));
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get all fee requests for the view all fee requests page
    public function getAllFeeRequests() {
        $sql = "SELECT * FROM fee_request 
                ORDER BY status='Pending' DESC, date DESC";
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt->execute()) {
            // Handle execution error
            die("Error executing query: " . implode(", ", $stmt->errorInfo()));
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        
}