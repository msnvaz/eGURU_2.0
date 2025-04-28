<?php

namespace App\Controllers\admin;

use App\Models\admin\AdminAnnouncementModel;

class AdminAnnouncementController {
    private $model;

    public function __construct() {
        $this->model = new AdminAnnouncementModel();
        $this->checkLogin();
    }

    private function checkLogin() {
        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            header('Location: /admin-login.php');
            exit();
        }
    }

    public function showAnnouncements() {
        $announcementsData = $this->model->getActiveAnnouncements();
        $announcements = $announcementsData['announcements'] ?? [];
        include __DIR__ . '/../../Views/admin/AdminAnnouncement.php';
    }

    public function showCreateForm() {
        include __DIR__ . '/../../Views/admin/AdminAnnouncement.php';
    }

    public function showUpdateForm($id) {
        $announcement = $this->model->getAnnouncementById($id);
        if (!$announcement) {
            header("Location: /admin-announcements?error=Announcement not found");
            exit();
        }
        include __DIR__ . '/../../Views/admin/AdminAnnouncement.php';
    }

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

    public function deleteAnnouncement($id) {
        $result = $this->model->softDeleteAnnouncement($id);
        header("Location: /admin-announcement");
        exit();
    }
}
