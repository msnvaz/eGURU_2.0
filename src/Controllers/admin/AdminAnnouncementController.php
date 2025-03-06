<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminAnnouncementModel;

class AdminAnnouncementController {
    private $model;

    public function __construct() {
        $this->model = new AdminAnnouncementModel();
        $this->checkLogin();
    }

    // Ensure admin is logged in
    private function checkLogin() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login.php');
            exit();
        }
    }

    // Show all active announcements
    public function showAnnouncements() {
        $announcementsData = $this->model->getAllAnnouncements();
        $announcements = $announcementsData['announcements'] ?? [];
        include __DIR__ . '/../../Views/admin/AdminAnnouncement.php';
    }

    // Show form to create a new announcement
    public function showCreateForm() {
        include __DIR__ . '/../../Views/admin/AdminAnnouncement.php';
    }

    // Show form to update an existing announcement
    public function showUpdateForm($id) {
        $announcement = $this->model->getAnnouncementById($id);
        if (!$announcement) {
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
                header("Location: /admin-announcement");
            } else {
                header("Location: /admin-announcements/");
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
                header("Location: /admin-announcement");
            } else {
                header("Location: /admin-announcement");
            }
            exit();
        }
    }

    // Soft delete an announcement
    public function softDeleteAnnouncement($id) {
        $result = $this->model->softDeleteAnnouncement($id);
        header("Location: /admin-announcement?success=" . ($result ? "Announcement archived successfully" : "Failed to archive announcement"));
        exit();
    }
}