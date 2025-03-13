<?php

namespace App\Controllers;

use App\Models\VisitorQueryModel;

class VisitorQueryController {
    private $model;

    public function __construct() {
        $this->model = new VisitorQueryModel();
    }

    public function storeVisitorQuery() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Retrieve user input
            $first_name = trim($_POST['first_name'] ?? '');
            $last_name = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $district = trim($_POST['district'] ?? '');
            $message = trim($_POST['message'] ?? '');

            // Validate input
            if (empty($first_name) || empty($last_name) || empty($email) || empty($district) || empty($message)) {
                echo "All fields are required.";
                return;
            }

            // Store in database
            $success = $this->model->createVisitorQuery($first_name, $last_name, $email, $district, $message);

            if ($success) {
                echo "Query submitted successfully.";
            } else {
                echo "Failed to submit query.";
            }
        } else {
            echo "Invalid request method.";
        }
    }
}
