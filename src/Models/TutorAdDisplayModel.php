<?php

namespace App\Models;

use Config\Database;

class TutorAdDisplayModel
{
    public function getUniqueAdsForTutors()
    {
        $db = Database::connect(); // ✅ Get default DB connection

        $sql = "SELECT DISTINCT t.tutor_id, ta.ad_display_pic
                FROM tutor_advertisement ta
                JOIN tutor t ON ta.ad_id = t.tutor_ad_id
                WHERE ta.ad_status = 'set'";

        $query = $db->query($sql);
        $data = $query->getResultArray(); // ✅ Returns array like fetch_assoc()

        return $data;
    }
}
