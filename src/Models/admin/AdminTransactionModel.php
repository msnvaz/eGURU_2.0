<?php

namespace App\Models\admin;

use App\Config\Database;
use PDO;

class AdminTransactionModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->Connect();
    }

    public function getAllPayments() {
        $query = "SELECT * FROM session_payments";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Additional methods for updating and deleting transactions can be added here
}
