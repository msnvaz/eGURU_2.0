<?php

namespace App\Models;

use App\Config\Database;

class TutorAdDisplayModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getFiveUniqueAds()
{
    $sql = "SELECT DISTINCT ad_display_pic
            FROM tutor_advertisement
            WHERE ad_status = 'set'
            LIMIT 5";

    $stmt = $this->conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

}
