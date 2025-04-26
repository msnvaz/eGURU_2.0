<?php

namespace App\Controllers;

use App\Models\StudentReviewModel;

class StudentReviewController
{
    public function showTestimonials()
    {
        $model = new StudentReviewModel();
        $testimonials = $model->getTopTestimonials();
        return $testimonials; // <<< Just return, do NOT require view here
    }
}
