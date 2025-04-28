<?php

namespace App\Controllers\student;

use App\Models\student\StudentPaymentsModel;

class StudentPaymentController {
    private $model;

    public function __construct() {
        $this->model = new StudentPaymentsModel();
    }

    
    public function showPayment() {
        
        $studentId = $_SESSION['student_id'] ?? null;
        
        
        $paymentHistory = [];
        if ($studentId) {
            $paymentHistory = $this->model->getPaymentHistory($studentId);
        }
        
        include '../src/Views/student/payments.php';
    }

    
    public function processPayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
            $points = isset($_POST['points']) ? (int)$_POST['points'] : 0;
            $email = $_POST['email'] ?? '';
            
            
            $_SESSION['payment_info'] = [
                'amount' => $amount,
                'points' => $points,
                'email' => $email,
                'timestamp' => time()
            ];
            
            
            header('Location: index.php?action=checkout');
            exit;
        }
    }

    
public function checkout() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $amount = $_POST['amount'] ?? 0;
        $points = $_POST['points'] ?? 0;

       
        $_SESSION['payment_info'] = [
            'amount' => $amount,
            'points' => $points,
        ];

        
        include '../src/Views/student/checkout.php';
    } else {
       
        header('Location: index.php?action=payment');
        exit;
    }
}

  
public function paymentSuccess() {
    
    if (isset($_SESSION['payment_info']) && isset($_SESSION['student_id'])) {
        $paymentInfo = $_SESSION['payment_info'];
        $studentId = $_SESSION['student_id'];
        
        
        $transactionId = 'TXN' . $studentId . strtoupper(substr(md5(uniqid()), 0, 1));
        
        
        $result = $this->model->storePayment(
            $studentId,
            $paymentInfo['points'],
            $paymentInfo['amount'],
            $transactionId
        );

        $this->model->updateStudentPoints($studentId, $paymentInfo['points']);
        
        if (!$result) {
            
            error_log("Failed to store payment in database");
            $_SESSION['payment_error'] = 'There was an error processing your payment. Please contact support.';
            header('Location: index.php?action=payment');
            exit;
        }
        
        
        $points = $paymentInfo['points'];
        
        
        include '../src/Views/student/success.php';
        
        
        unset($_SESSION['payment_info']);
    } else {
        
        header('Location: index.php?action=payment');
        exit;
    }
}

    
    public function paymentCancel() {
        
        unset($_SESSION['payment_info']);
        
       
        $_SESSION['payment_error'] = 'Payment was cancelled. Please try again.';
        header('Location: index.php?action=payment');
        exit;
    }

    
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