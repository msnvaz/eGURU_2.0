<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminInboxModel;

class AdminInboxController {
    private $model;

    public function __construct() {
        $this->model = new AdminInboxModel();
    }

    public function index() {
        // Fetch messages with optional filtering
        $filter = $_GET['filter'] ?? 'all';
        $search = $_GET['search'] ?? '';
        $sort = $_GET['sort'] ?? 'newest';

        $messages = $this->model->getFilteredMessages($filter, $search, $sort);
        
        require_once __DIR__ . '/../../Views/admin/AdminInbox.php';
    }

    public function sendMessage() {
        // Logic to handle sending a message
        $data = [
            'sender_type' => $_POST['sender_type'],
            'sender_name' => $_POST['sender_name'],
            'subject' => $_POST['subject'],
            'message' => $_POST['message']
        ];
        $this->model->sendMessage($data);
        // Redirect or load the inbox view again
    }
}
