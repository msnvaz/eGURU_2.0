<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorDetailsModel;

class TutorPaymentController {
    private $model;

    public function __construct() {
        $this->model = new TutorDetailsModel();
    }

    
    public function showPaymentPage() {
        
        require_once __DIR__ . '/../../Views/tutor/payment.php';
    }


    
}