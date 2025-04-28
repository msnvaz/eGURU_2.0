<?php
namespace App\Controllers\admin;

use App\Models\admin\FeeRequestModel;

class FeeRequestController {
    private $feeRequestModel;

    public function __construct() {
        $this->feeRequestModel = new FeeRequestModel(); 
    }

    public function showFeeRequests() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: login.php'); 
            exit();
        }

        $feeRequests = $this->feeRequestModel->getAllFeeRequests(); 

        require_once __DIR__ . '/../../Views/admin/ProfilesNOthers/FeeRequests/AllFeeRequests.php';
    }
}
?>