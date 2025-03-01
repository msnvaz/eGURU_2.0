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
        error_log('Controller: showAllSessions method called');
        
        if (isset($_POST['search']) && isset($_POST['search_term']) && !empty($_POST['search_term'])) {
            error_log('Search initiated with term: ' . $_POST['search_term']);
            $sessions = $this->model->searchSessions($_POST['search_term']);
        } else {
            error_log('Showing all sessions (no search term)');
            $sessions = $this->model->getAllSessions();
        }

        require_once __DIR__ . '/../../Views/admin/AdminSessions.php';
    }
}