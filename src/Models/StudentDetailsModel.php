<?php

namespace App\Models;

use App\Config\database;
use PDO;

class StudentDetailsModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllStudents() {
        $query = $this->conn->query("SELECT * FROM students");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}