<?php
namespace App\Controllers;

use App\Models\AnnouncementModel;
use App\Config\Database;

class DisplayAnnouncementController {
    private $announcementModel;

    public function __construct() {
        $db = Database::getInstance();
        $this->announcementModel = new AnnouncementModel($db);
    }

    public function displayAnnouncements() {
        $announcements = $this->announcementModel->getAllAnnouncements();
        include_once __DIR__ . "/../Views/announcement.php";
    }
}
