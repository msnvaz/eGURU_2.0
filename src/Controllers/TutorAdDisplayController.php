<?php

namespace App\Controllers;

use App\Models\TutorAdDisplayModel;

class TutorAdDisplayController
{
    public function index()
    {
        $model = new TutorAdDisplayModel();
        $ads = $model->getFiveUniqueAds();
        require __DIR__ . '/../Views/tutor_ad_display.php';
    }

    public function getAds()
    {
        $model = new TutorAdDisplayModel();
        return $model->getFiveUniqueAds();
    }
}
