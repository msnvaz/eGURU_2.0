<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorTimeSlotModel;

class TutorTimeSlotController {
    private $model;

    public function __construct() {
        $this->model = new TutorTimeSlotModel();
    }

    public function showTutorTimeSlotPage() {
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        $tutorId = $_SESSION['tutor_id'];
        $allTimeSlots = $this->model->getAllTimeSlots();
        $selectedSlots = $this->model->getTutorTimeSlots($tutorId);

        require_once __DIR__ . '/../../Views/tutor/timeslot.php';
    }

    public function saveTutorTimeSlots() {
        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        $tutorId = $_SESSION['tutor_id'];
        $slotSelections = [];

        
        $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
        foreach ($days as $day) {
            if (!empty($_POST[$day])) {
                $slotSelections[$day] = $_POST[$day];  // $day => [slot_ids]
            }
        }

        $this->model->saveTutorTimeSlots($tutorId, $slotSelections);

        header("Location: /tutor-timeslot?success=1");
        exit;
    }
}
