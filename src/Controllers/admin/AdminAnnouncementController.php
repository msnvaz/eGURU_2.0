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
        $announcementsData = $this->model->getActiveAnnouncements();
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

    // Create a new announcement with title
    public function createAnnouncement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['announcement'])) {
            $title = trim($_POST['title']);
            $announcement = trim($_POST['announcement']);
            
            if (!empty($title) && !empty($announcement)) {
                $this->model->createAnnouncement($title, $announcement);
                header("Location: /admin-announcement");
            } else {
                header("Location: /admin-announcements?error=Fields cannot be empty");
            }
            exit();
        }
    }
    
    // Update an existing announcement with title
    public function updateAnnouncement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['announce_id'], $_POST['title'], $_POST['announcement'])) {
            $id = intval($_POST['announce_id']);
            $title = trim($_POST['title']);
            $announcement = trim($_POST['announcement']);
            
            if (!empty($title) && !empty($announcement)) {
                $this->model->updateAnnouncement($id, $title, $announcement);
                header("Location: /admin-announcement");
            } else {
                header("Location: /admin-announcement");
            }
            exit();
        }
    }

    // Soft delete an announcement by setting status to "inactive"
    public function deleteAnnouncement($id) {
        $result = $this->model->softDeleteAnnouncement($id);
        header("Location: /admin-announcement");
        exit();
    }
}
