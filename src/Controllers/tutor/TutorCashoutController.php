<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorCashoutModel;

class TutorCashoutController {
    private $model;

    public function __construct() {
        $this->model = new TutorCashoutModel();
    }

    /**
     * Show the cashout form
     */
    public function showCashout() {

        //session_start();
        
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
        // Get tutor ID from session
        $tutorId = $_SESSION['tutor_id'] ?? null;
        
        if (!$tutorId) {
            // Redirect to login if not logged in
            header('Location: /tutor-login');
            exit;
        }
        
        // Get tutor info including current points
        $tutorInfo = $this->model->getTutorInfo($tutorId);
        
        // Get cashout history for displaying
        $cashoutHistory = $this->model->getCashoutHistory($tutorId);
        
        // Get point value (how much cash per point)
        $pointValue = $this->model->getPointValue();
        
        // Get platform fee percentage
        $platformFee = $this->model->getPlatformFee();
        
        include '../src/Views/tutor/cashout.php';
    }

    /**
     * Process the cashout form submission
     */
    public function processCashout() {
        //session_start();
        
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the tutor ID from session
            $tutorId = $_SESSION['tutor_id'] ?? null;
            
            if (!$tutorId) {
                // Redirect to login if not logged in
                header('Location: /tutor-login');
                exit;
            }
            
            // Get current tutor points
            $tutorInfo = $this->model->getTutorInfo($tutorId);
            $currentPoints = $tutorInfo['tutor_points'] ?? 0;
            
            // Get form data
            $pointsToCashout = isset($_POST['points']) ? (int)$_POST['points'] : 0;
            
            // Validate points
            if ($pointsToCashout <= 0) {
                $_SESSION['cashout_error'] = 'Please enter a valid number of points to cash out.';
                header('Location: index.php?action=cashout');
                exit;
            }
            
            if ($pointsToCashout > $currentPoints) {
                $_SESSION['cashout_error'] = 'You cannot cash out more points than you have.';
                header('Location: index.php?action=cashout');
                exit;
            }
            
            // Calculate cash value
            $pointValue = $this->model->getPointValue();
            $platformFee = $this->model->getPlatformFee();
            
            $grossCashValue = $pointsToCashout * $pointValue;
            $feeAmount = $grossCashValue * ($platformFee / 100);
            $netCashValue = $grossCashValue - $feeAmount;
            
            // Store cashout info in session for processing
            $_SESSION['cashout_info'] = [
                'points' => $pointsToCashout,
                'gross_value' => $grossCashValue,
                'fee_amount' => $feeAmount,
                'net_value' => $netCashValue,
                'fee_percentage' => $platformFee,
                'timestamp' => time()
            ];
            
            // Process via Stripe Connect
            // In a real application, you would create a Stripe transfer here
            // For now, we'll simulate the process and redirect to success
            
            // Generate a transaction ID
            $transactionId = 'TXN' . $tutorId . strtoupper(substr(md5(uniqid()), 0, 8));

            $_SESSION['transaction_id'] = $transactionId;
            
            // Store in database and update tutor points
            $result = $this->model->storeCashout(
                $tutorId,
                $pointsToCashout,
                $netCashValue,
                $transactionId
            );
            
            if (!$result) {
                $_SESSION['cashout_error'] = 'There was an error processing your cashout. Please try again.';
                header('Location: index.php?action=cashout');
                exit;
            }
            
            // Update tutor points
            $this->model->updateTutorPoints($tutorId, $currentPoints - $pointsToCashout);
            
            // Redirect to success page
            header('Location: index.php?action=cashout_success');
            exit;
        } else {
            // Redirect to cashout page if accessed via GET
            header('Location: index.php?action=cashout');
            exit;
        }
    }

    /**
     * Handle the cashout success
     */
    public function cashoutSuccess() {

        //session_start();
        
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
        // Check if cashout info exists in session
        if (isset($_SESSION['cashout_info']) && isset($_SESSION['tutor_id'])) {
            $cashoutInfo = $_SESSION['cashout_info'];
            
            // Show the success page
            include '../src/Views/tutor/cashout_success.php';
            
            // Clear cashout info from session after showing the success page
            unset($_SESSION['cashout_info']);
        } else {
            // Redirect to cashout page if no cashout info found
            header('Location: index.php?action=cashout');
            exit;
        }
    }

    /**
     * Handle cashout cancellation
     */
    public function cashoutCancel() {
        // Clear cashout info from session
        unset($_SESSION['cashout_info']);
        
        // Redirect back to cashout page with error message
        $_SESSION['cashout_error'] = 'Cashout was cancelled. Please try again.';
        header('Location: index.php?action=cashout');
        exit;
    }
}