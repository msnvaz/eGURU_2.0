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

    public function showTransactions() {
        if (isset($_POST['search'])) {
            $searchTerm = $_POST['search_term'];
            $payments = $this->transactionModel->searchPayments($searchTerm); // Fetch filtered payments
        } else {
            $payments = $this->transactionModel->getAllPayments(); // Fetch all payments
        }

        require_once __DIR__ . '/../../Views/admin/AdminTransactions.php';
    }

    public function refund($id)
    {
        $result = $this->transactionModel->updateTransactionStatus($id, 'refunded');
        
        if ($result) {
            // If refund was successful
            $_SESSION['refund_success'] = "Refund processed successfully.";
        } else {
            // If refund failed - likely because tutor doesn't have enough points or payment was already refunded
            $_SESSION['refund_error'] = "Refund failed. Please check if tutor has enough points or if payment was already refunded.";
        }
        
        header('Location: /admin/transactions'); // Redirect back to transactions page
        exit();
    }
}