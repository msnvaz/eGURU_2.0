<?php

namespace App\Controllers\tutor;

use App\Models\tutor\TutorCashoutModel;

class TutorCashoutController {
    private $model;

    public function __construct() {
        $this->model = new TutorCashoutModel();
    }

    
    public function showCashout() {

        
        
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
        
        $tutorId = $_SESSION['tutor_id'] ?? null;
        
        if (!$tutorId) {
            
            header('Location: /tutor-login');
            exit;
        }
        
        
        $tutorInfo = $this->model->getTutorInfo($tutorId);
        
        
        $cashoutHistory = $this->model->getCashoutHistory($tutorId);
        
        
        $pointValue = $this->model->getPointValue();
        
        
        $platformFee = $this->model->getPlatformFee();
        
        include '../src/Views/tutor/cashout.php';
    }

    
    public function processCashout() {
       
        
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $tutorId = $_SESSION['tutor_id'] ?? null;
            
            if (!$tutorId) {
                
                header('Location: /tutor-login');
                exit;
            }
            
            
            $tutorInfo = $this->model->getTutorInfo($tutorId);
            $currentPoints = $tutorInfo['tutor_points'] ?? 0;
            
            
            $pointsToCashout = isset($_POST['points']) ? (int)$_POST['points'] : 0;
            
            
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
            
            
            $pointValue = $this->model->getPointValue();
            $platformFee = $this->model->getPlatformFee();
            
            $grossCashValue = $pointsToCashout * $pointValue;
            $feeAmount = $grossCashValue * ($platformFee / 100);
            $netCashValue = $grossCashValue - $feeAmount;
            
            
            $_SESSION['cashout_info'] = [
                'points' => $pointsToCashout,
                'gross_value' => $grossCashValue,
                'fee_amount' => $feeAmount,
                'net_value' => $netCashValue,
                'fee_percentage' => $platformFee,
                'timestamp' => time()
            ];
            
            
            $transactionId = 'TXN' . $tutorId . strtoupper(substr(md5(uniqid()), 0, 8));

            $_SESSION['transaction_id'] = $transactionId;
            
            
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
            
            
            $this->model->updateTutorPoints($tutorId, $currentPoints - $pointsToCashout);
            
            
            header('Location: index.php?action=cashout_success');
            exit;
        } else {
            
            header('Location: index.php?action=cashout');
            exit;
        }
    }

   
    public function cashoutSuccess() {

       
        
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
            exit;
        }
       
        if (isset($_SESSION['cashout_info']) && isset($_SESSION['tutor_id'])) {
            $cashoutInfo = $_SESSION['cashout_info'];
            
            
            include '../src/Views/tutor/cashout_success.php';
            
            
            unset($_SESSION['cashout_info']);
        } else {
            
            header('Location: index.php?action=cashout');
            exit;
        }
    }

    
    public function cashoutCancel() {
        
        unset($_SESSION['cashout_info']);
        
        
        $_SESSION['cashout_error'] = 'Cashout was cancelled. Please try again.';
        header('Location: index.php?action=cashout');
        exit;
    }
}