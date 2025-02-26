<?php
namespace App\Controllers\admin;
use App\Models\admin\adminSessionModel;

class adminSessionController {
    private $model;

    public function __construct() {
        $this->model = new adminSessionModel();
    }

    public function showAllSessions() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login');
            exit();
        }

        $sessions = [];
        error_log('Fetching sessions: ' . print_r($sessions, true)); // Debugging statement

        
        if (isset($_POST['search']) && !empty($_POST['search_term'])) {
            error_log('Search term provided: ' . $_POST['search_term']); // Debugging statement

            $sessions = $this->model->searchSessions($_POST['search_term']);
        } else {
            $sessions = $this->model->getAllSessions();
        }

        require_once __DIR__ . '/../../Views/admin/AdminSessions.php';
    }
}
