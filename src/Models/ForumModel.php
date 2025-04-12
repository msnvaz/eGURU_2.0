<?php
namespace App\Models;

use App\Config\Database;
use PDO;
class ForumModel
{
    private $db;

    public function __construct($db)
{
    if (!$db instanceof PDO) {
        die("Invalid DB connection");
    }
    $this->db = $db;
}


    public function getAllMessagesWithStudentName()
    {
        $sql = "SELECT f.message_id, f.message, f.time, s.student_first_name
                FROM forum f
                LEFT JOIN student s ON f.student_id = s.student_id
                ORDER BY f.time DESC;";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
