<?php

namespace App\Controllers;

use App\Models\TutorAdDisplayModel;

class TutorAdDisplayController
{
    public function index()
    {
        $model = new TutorAdDisplayModel();

        // ✅ Fetch the ad data
        $ads = $model->getUniqueAdsForTutors();

        // ✅ Pass it to the view
        return view('tutor_ad_display', ['ads' => $ads]);
    }
}
