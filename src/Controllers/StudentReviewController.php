<?php

namespace App\Controllers;

use App\Models\StudentReviewModel;

class StudentReviewController
{
    public function showTestimonials()
    {
        $model = new StudentReviewModel();
        $testimonials = $model->getTopTestimonials();
        return $testimonials; 
    }
}
