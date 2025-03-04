<?php

namespace App\Controllers\manager;

use App\Models\manager\AnnouncementModel;

class ManagerAnnouncementController {
    private $model;

    public function __construct() {
        $this->model = new AnnouncementModel();
        $this->checkLogin();
    }

    // Ensure manager is logged in
    private function checkLogin() {
        if (!isset($_SESSION['manager_logged_in']) || $_SESSION['manager_logged_in'] !== true) {
            header('Location: ../../manager-login.php');
            exit();
        }
    }

    // Show announcements page with data
    public function showAnnouncements() {
        $announcements = $this->model->getAllAnnouncements();
        
        // Debugging: Check if announcements are retrieved correctly
        if (!$announcements) {
            $announcements = [];
        }

        include __DIR__ . '/../../Views/manager/announcement.php';
    }

    // Handle different actions (create, update, delete)
    public function handleRequest() {
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'create':
                    $this->createAnnouncement();
                    break;
                case 'update':
                    $this->updateAnnouncement();
                    break;
                case 'delete':
                    $this->deleteAnnouncement();
                    break;
                default:
                    $this->showAnnouncements();
                    break;
            }
        } else {
            $this->showAnnouncements();
        }
    }

    // Create a new announcement
    public function createAnnouncement($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announcement'])) {
            $announcement = trim($_POST['announcement']);
            if (!empty($announcement)) {
                $result = $this->model->addAnnouncement($announcement);
                header("Location: ../../Views/manager/announcement.php?success=" . ($result ? "Announcement added successfully" : "Failed to add announcement"));
            } else {
                header("Location: ../../Views/manager/announcement.php?error=Announcement cannot be empty");
            }
            exit();
        }
    }

    // Update an existing announcement
    public function updateAnnouncement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announce_id']) && isset($_POST['announcement'])) {
            $id = intval($_POST['announce_id']);
            $announcement = trim($_POST['announcement']);
            if (!empty($announcement)) {
                $result = $this->model->updateAnnouncement($id, $announcement);
                header("Location: ../../Views/manager/announcement.php?success=" . ($result ? "Announcement updated successfully" : "Failed to update announcement"));
            } else {
                header("Location: ../../Views/manager/announcement.php?error=Announcement cannot be empty");
            }
            exit();
        }
    }

    // Delete an announcement
    public function deleteAnnouncement() {
        if (isset($_GET['delete_id'])) {
            $id = intval($_GET['delete_id']);
            $result = $this->model->deleteAnnouncement($id);
            header("Location: ../../Views/manager/announcement.php?success=" . ($result ? "Announcement deleted successfully" : "Failed to delete announcement"));
            exit();
        }
    }
}

// Start handling request
$controller = new ManagerAnnouncementController();
$controller->handleRequest();
