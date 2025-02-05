<?php
namespace App\Controllers\admin;

use App\Models\admin\FeeRequestModel;

class FeeRequestController {
    private $feeRequestModel;

    public function __construct() {
        $this->feeRequestModel = new FeeRequestModel(); // Instantiate the FeeRequestModel
    }

    public function showFeeRequests() {
        // Check if admin is logged in
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: login.php'); // Redirect to login page if not logged in
            exit();
        }

        // Fetch fee requests
        $feeRequests = $this->feeRequestModel->getAllFeeRequests(); // Get fee requests

        // Include the views and pass the data
        require_once __DIR__ . '/../../Views/admin/ProfilesNOthers/FeeRequests/AllFeeRequests.php';
    }
}
?>