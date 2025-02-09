<?php

namespace App\Controllers\student;

use App\Models\student\SessionRequestModel;

class StudentSessionController {
    private $model;

    public function __construct() {
        $this->model = new SessionRequestModel();
    }

    public function showSession() {
        include '../src/Views/student/session.php';
    }

    public function getPendingRequests() {
        if (!isset($_SESSION['student_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'User not authenticated']);
            exit;
        }
    
        $student_id = $_SESSION['student_id'];
        $pendingRequests = $this->model->getPendingRequestsByStudent($student_id);
        
    
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'requests' => $pendingRequests]);
        exit;
    }

    public function cancelRequest() {
        if (!isset($_SESSION['student_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'User not authenticated']);
            exit;
        }

        $student_id = $_SESSION['student_id'];
        $request_id = isset($_POST['request_id']) ? $_POST['request_id'] : null;

        if (!$request_id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            exit;
        }

        $result = $this->model->cancelRequest($request_id, $student_id);

        header('Content-Type: application/json');
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Request cancelled successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to cancel request']);
        }
        exit;
    }}