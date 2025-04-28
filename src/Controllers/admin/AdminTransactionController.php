<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminTransactionModel; 
use App\Controller;

class AdminTransactionController extends Controller
{
    protected $transactionModel;

    public function __construct()
    {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); 
            exit();
        } 
        $this->transactionModel = new AdminTransactionModel();
    }

    public function showTransactions() {
        if (isset($_POST['search'])) {
            $searchTerm = $_POST['search_term'];
            $payments = $this->transactionModel->searchPayments($searchTerm); 
        } else {
            $payments = $this->transactionModel->getAllPayments(); 
        }

        require_once __DIR__ . '/../../Views/admin/AdminTransactions.php';
    }

    public function refund($id)
    {
        $result = $this->transactionModel->updateTransactionStatus($id, 'refunded');
        
        if ($result) {
            $_SESSION['refund_success'] = "Refund processed successfully.";
        } else {
            $_SESSION['refund_error'] = "Refund failed. Please check if tutor has enough points or if payment was already refunded.";
        }
        
        header('Location: /admin-transactions');  
        exit();
    }
}