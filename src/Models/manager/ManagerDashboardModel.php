<?php

// src/Models/admin/AdminDashboardModel.php
namespace App\Models\manager;

use App\Config\Database;
use PDO;

class ManagerDashboardModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();

        if ($this->conn === null) {
            die('Error connecting to the database');
        }
    }

}