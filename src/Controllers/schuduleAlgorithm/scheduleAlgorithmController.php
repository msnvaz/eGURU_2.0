<?php

namespace App\Controllers;

use App\Models\scheduleAlgorithm\scheduleAlgorithmModel;

class scheduleAlgorithmController {
    private $model;

    public function __construct() {
        $this->model = new scheduleAlgorithmModel();
    }

    public function getAvailableTimeSlots() {
        // Add debug logging
        error_log("scheduleAlgorithmController::getAvailableTimeSlots called");
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        // Debug session state
        error_log("Session state: " . print_r($_SESSION, true));
        
        if (!isset($_SESSION['student_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized: No student_id in session']);
            exit();
        }
    
        // Get data from request
        $inputData = file_get_contents('php://input');
        error_log("Raw input: " . $inputData);
        
        $data = json_decode($inputData, true);
        error_log("Decoded input: " . print_r($data, true));
        
        if (!isset($data['tutorId']) || empty($data['tutorId'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing tutor ID']);
            exit();
        }
    
        $studentId = $_SESSION['student_id'];
        $tutorId = $data['tutorId'];
        
        error_log("Processing request for tutorId: $tutorId, studentId: $studentId");
    
        try {
            // Get available time slots
            $availableSlots = $this->model->checkAvailability($tutorId, $studentId);
            error_log("Available slots: " . print_r($availableSlots, true));
            
            // Format the time slots for display
            $formattedSlots = [];
            foreach ($availableSlots as $slot) {
                // Calculate the next date for this day of week
                $dayOfWeek = $slot['day'];
                $currentDayNum = date('N'); // 1 (Monday) to 7 (Sunday)
                $dayNum = [
                    'Monday' => 1,
                    'Tuesday' => 2,
                    'Wednesday' => 3,
                    'Thursday' => 4,
                    'Friday' => 5,
                    'Saturday' => 6,
                    'Sunday' => 7
                ][$dayOfWeek];
                
                // Calculate days until the next occurrence of this day
                $daysUntil = ($dayNum >= $currentDayNum) ? 
                    $dayNum - $currentDayNum : 
                    7 - ($currentDayNum - $dayNum);
                
                // Calculate the date
                $date = date('Y-m-d', strtotime("+{$daysUntil} days"));
                
                // Format the time
                $startTime = sprintf('%02d:00:00', $slot['starting_time']);
                $endTime = sprintf('%02d:00:00', $slot['ending_time']);
                
                $formattedSlots[] = [
                    'day' => $dayOfWeek,
                    'date' => $date,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'timeSlotId' => $slot['time_slot_id'],
                    'displayText' => "$dayOfWeek, $date, $startTime - $endTime"
                ];
            }
            
            error_log("Formatted slots: " . print_r($formattedSlots, true));
            echo json_encode(['availableSlots' => $formattedSlots]);
            
        } catch (\Exception $e) {
            error_log("Error in getAvailableTimeSlots: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
        }
    }
}