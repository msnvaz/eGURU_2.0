<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class PublicSubjectsModel {
    private $conn;

    public function __construct() {
        // Create a new database connection
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getSubjects() {
        // Prepare the SQL statement
        $stmt = $this->conn->prepare("SELECT * FROM tutor_new");
        // Execute the SQL statement
        $stmt->execute();
        // Return the result
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}