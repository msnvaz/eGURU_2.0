<?php

namespace App\Controllers;

use App\Models\StudentReviewModel;

class StudentReviewController
{
    public function showTestimonials()
    {
        // Do NOT require the model again — it's already imported via the 'use' statement
        $model = new StudentReviewModel();
        $testimonials = $model->getTopTestimonials(); // Gets testimonial array

        // Make $testimonials available to the view
        require __DIR__ . '/../Views/studentreview.php';
    }
}
