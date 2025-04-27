<?php

namespace App\Controllers\student;

use App\Models\student\StudentPaymentsModel;

class StudentPaymentController {
    private $model;

    public function __construct() {
        $this->model = new StudentPaymentsModel();
    }

    /**
     * Show the payment form
     */
    public function showPayment() {
        // Get student ID from session
        $studentId = $_SESSION['student_id'] ?? null;
        
        // Get payment history for displaying
        $paymentHistory = [];
        if ($studentId) {
            $paymentHistory = $this->model->getPaymentHistory($studentId);
        }
        
        include '../src/Views/student/payments.php';
    }

    /**
     * Process the payment form submission
     */
    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the payment amount and points from form
            $amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
            $points = isset($_POST['points']) ? (int)$_POST['points'] : 0;
            $email = $_POST['email'] ?? '';
            
            // Store payment info in session for later use
            $_SESSION['payment_info'] = [
                'amount' => $amount,
                'points' => $points,
                'email' => $email,
                'timestamp' => time()
            ];
            
            // Redirect to the checkout page
            header('Location: index.php?action=checkout');
            exit;
        }
    }

    
public function checkout() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve payment info from the form
        $amount = $_POST['amount'] ?? 0;
        $points = $_POST['points'] ?? 0;

        // Store payment info in session for further processing
        $_SESSION['payment_info'] = [
            'amount' => $amount,
            'points' => $points,
        ];

        // Redirect to the payment gateway or display the checkout page
        include '../src/Views/student/checkout.php';
    } else {
        // If accessed via GET, redirect to the payment page
        header('Location: index.php?action=payment');
        exit;
    }
}

    /**
 * Handle the payment success
 */
public function paymentSuccess() {
    // Check if payment info exists in session
    if (isset($_SESSION['payment_info']) && isset($_SESSION['student_id'])) {
        $paymentInfo = $_SESSION['payment_info'];
        $studentId = $_SESSION['student_id'];
        
        // Generate a transaction ID
        $transactionId = 'TXN' . $studentId . strtoupper(substr(md5(uniqid()), 0, 1));
        
        // Store payment details in database
        $result = $this->model->storePayment(
            $studentId,
            $paymentInfo['points'],
            $paymentInfo['amount'],
            $transactionId
        );
        
        if (!$result) {
            // Log error and show error message
            error_log("Failed to store payment in database");
            $_SESSION['payment_error'] = 'There was an error processing your payment. Please contact support.';
            header('Location: index.php?action=payment');
            exit;
        }
        
        // Pass payment info and transaction ID to the success view
        $points = $paymentInfo['points'];
        
        // Show the success page
        include '../src/Views/student/success.php';
        
        // Clear payment info from session after showing the success page
        unset($_SESSION['payment_info']);
    } else {
        // Redirect to payment page if no payment info found
        header('Location: index.php?action=payment');
        exit;
    }
}

    /**
     * Handle payment cancellation
     */
    public function paymentCancel() {
        // Clear payment info from session
        unset($_SESSION['payment_info']);
        
        // Redirect back to payment page with error message
        $_SESSION['payment_error'] = 'Payment was cancelled. Please try again.';
        header('Location: index.php?action=payment');
        exit;
    }

    /**
     * Get available point packages
     * 
     * @return array Point packages with amount and points
     */
    public function getPointPackages() {
        return [
            [
                'points' => 100,
                'amount' => 1000,
                'description' => 'Perfect for starting out'
            ],
            [
                'points' => 300,
                'amount' => 2700,
                'description' => '10% savings on points'
            ],
            [
                'points' => 500,
                'amount' => 4000,
                'description' => '20% savings on points',
                'best_value' => true
            ],
            [
                'points' => 1000,
                'amount' => 7500,
                'description' => '25% savings on points'
            ]
        ];
    }
}