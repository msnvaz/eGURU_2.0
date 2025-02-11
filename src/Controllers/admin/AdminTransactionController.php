<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminTransactionModel; // Assuming a model exists for transactions
use App\Controller;

class AdminTransactionController extends Controller
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new AdminTransactionModel();
    }

    public function showTransactions()
    {
        $payments = $this->transactionModel->getAllPayments(); // Fetch all payments
        //$cashingOuts = $this->transactionModel->getAllCashingOuts(); // Fetch all cashing outs
        //return ['payments' => $payments, 'cashing_outs' => $cashingOuts]; // Return data for the view
        return ['payments'->$payments]; // Return data for the view
        require_once __DIR__ . '/../../Views/admin/AdminTransactions.php';
    }

    public function refund($id)
    {
        $this->transactionModel->updateTransactionStatus($id, 'refunded'); // Update transaction status to refunded
        header('Location: /admin/transactions'); // Redirect back to transactions page
    }
}
