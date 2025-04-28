<?php
namespace App\Controllers\student;

use App\Models\student\SessionRequestModel;

class StudentSessionController {
    private $model;

    public function __construct() {
        $this->model = new SessionRequestModel();
    }

    public function showSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            header("Location: /student-login");
            exit();
        }

        include '../src/Views/student/session.php';
    }

    public function getPendingRequests() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit();
        }

        try {
            $requests = $this->model->getPendingRequests($_SESSION['student_id']);
            error_log('Pending requests: ' . json_encode($requests)); 
            echo json_encode(['success' => true, 'requests' => $requests]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to retrieve pending requests: ' . $e->getMessage()]);
            error_log('Error in getPendingRequests: ' . $e->getMessage());
        }
    }

    public function getRequestResults() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit();
        }

        try {
            $results = $this->model->getRequestResults($_SESSION['student_id']);
            error_log('Request results: ' . json_encode($results)); 
            echo json_encode(['success' => true, 'requests' => $results]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Failed to retrieve request results: ' . $e->getMessage()]);
            error_log('Error in getRequestResults: ' . $e->getMessage());
        }
    }

    public function cancelRequest() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['sessionId'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid request: sessionId is required']);
            exit();
        }

        try {
            $success = $this->model->cancelRequest($data['sessionId'], $_SESSION['student_id']);
            
            if ($success) {
                echo json_encode(['success' => true]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Failed to cancel request. This request may no longer be cancelable.']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'An error occurred: ' . $e->getMessage()]);
            error_log('Error in cancelRequest: ' . $e->getMessage());
        }
    }

    public function getSessionDetails($sessionId) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Unauthorized']);
            exit();
        }

        if (!$sessionId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Session ID is required']);
            exit();
        }

        try {
            $details = $this->model->getSessionDetails($sessionId, $_SESSION['student_id']);
            
            if ($details) {
                echo json_encode($details);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Session not found']);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'An error occurred: ' . $e->getMessage()]);
            error_log('Error in getSessionDetails: ' . $e->getMessage());
        }
    }
}