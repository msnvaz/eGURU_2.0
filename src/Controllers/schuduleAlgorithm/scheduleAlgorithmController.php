<?php

namespace App\Controllers;

use App\Models\scheduleAlgorithm\scheduleAlgorithmModel;

class scheduleAlgorithmController {
    private $model;

    public function __construct() {
        $this->model = new scheduleAlgorithmModel();
    }

    public function checkAvailability($tutor_id, $student_id) {
        // Call the model method to check availability
        $availability = $this->model->checkAvailability($tutor_id, $student_id);

        // Return the availability data
        return $availability;
    }
}