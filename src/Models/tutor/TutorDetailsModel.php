<?php

namespace App\Models\tutor;

use App\config\database;
use PDO;

class TutorDetailsModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }
}