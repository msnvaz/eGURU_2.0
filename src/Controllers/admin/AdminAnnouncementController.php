<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminAnnouncementModel;

class AdminAnnouncementController {
    private $model;

    public function __construct() {
        $this->model = new AdminAnnouncementModel();
        $this->checkLogin();
    }

    // Ensure manager is logged in
    private function checkLogin() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login.php');
            exit();
        }
    }

    // Show all announcements
    public function showAnnouncements() {
        $announcements = $this->model->getAllAnnouncements() ?: [];
        include __DIR__ . '/../../Views/admin/AdminAnnouncement.php';
    }

    // Show create announcement form
    public function showCreateForm() {
        include __DIR__ . '/../../Views/admin/AdminAnnouncement.php';
    }

    // Show update announcement form
    public function showUpdateForm($id) {
        $announcement = $this->model->getAnnouncementById($id);
        if (!$announcement) {
            // Handle not found scenario
            header("Location: /admin-announcements?error=Announcement not found");
            exit();
        }
        include __DIR__ . '/../../Views/admin/AdminAnnouncement.php';
    }

    // Create a new announcement
    public function createAnnouncement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announcement'], $_POST['status'])) {
            $announcement = trim($_POST['announcement']);
            $status = in_array($_POST['status'], ['active', 'inactive']) ? $_POST['status'] : 'inactive';
            
            if (!empty($announcement)) {
                $result = $this->model->createAnnouncement($announcement, $status);
                header("Location: /admin-announcements?success=" . ($result ? "Announcement added successfully" : "Failed to add announcement"));
            } else {
                header("Location: /admin-announcements/create?error=Announcement cannot be empty");
            }
            exit();
        }
    }

    // Update an existing announcement
    public function updateAnnouncement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announce_id'], $_POST['announcement'], $_POST['status'])) {
            $id = intval($_POST['announce_id']);
            $announcement = trim($_POST['announcement']);
            $status = in_array($_POST['status'], ['active', 'inactive']) ? $_POST['status'] : 'inactive';
            
            if (!empty($announcement)) {
                $result = $this->model->updateAnnouncement($id, $announcement, $status);
                header("Location: /admin-announcements?success=" . ($result ? "Announcement updated successfully" : "Failed to update announcement"));
            } else {
                header("Location: /admin-announcements/update/{$id}?error=Announcement cannot be empty");
            }
            exit();
        }
    }

    // Delete an announcement
    public function deleteAnnouncement($id) {
        $result = $this->model->deleteAnnouncement($id);
        header("Location: /admin-announcements?success=" . ($result ? "Announcement deleted successfully" : "Failed to delete announcement"));
        exit();
    }
}
