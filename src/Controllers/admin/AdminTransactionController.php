<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminTransactionModel; // Assuming a model exists for transactions
use App\Controller;

class AdminTransactionController extends Controller
{
    protected $transactionModel;

    public function __construct()
    {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login'); // Redirect to login page if not logged in
            exit();
        } 
        $this->transactionModel = new AdminTransactionModel();
    }

    public function showTransactions()
    {
        $payments = $this->transactionModel->getAllPayments(); // Fetch all payments
        
        require_once __DIR__ . '/../../Views/admin/AdminTransactions.php';
    }

    public function refund($id)
    {
        $this->transactionModel->updateTransactionStatus($id, 'refunded'); // Update transaction status to refunded
        header('Location: /admin/transactions'); // Redirect back to transactions page
    }
}
