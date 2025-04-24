<?php

namespace App\Controllers;

use App\Models\TutorAdDisplayModel;

class TutorAdDisplayController
{
    // Original method used when routed directly
    public function index()
    {
        $model = new TutorAdDisplayModel();
        $ads = $model->getFiveUniqueAds();
        require __DIR__ . '/../Views/tutor_ad_display.php';
    }

    // ✅ New method to use when including the view in other files
    public function getAds()
    {
        $model = new TutorAdDisplayModel();
        return $model->getFiveUniqueAds();
    }
}
