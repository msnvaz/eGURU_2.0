<?php
namespace App\Controllers;

use App\Models\DisplayAnnouncementModel;
use App\Config\Database;

class DisplayAnnouncementController {
    private $announcementModel;

    public function __construct() {
        // Create a new database connection
        $db = new Database();  // Instantiate Database class
        $this->announcementModel = new DisplayAnnouncementModel($db->connect()); // Pass the connection to the model
    }

    public function displayAnnouncements() {
        $announcements = $this->announcementModel->getAllAnnouncements();
        return $this->announcementModel->getAllAnnouncements(); // Return announcements instead of including a file
        include_once __DIR__ . "/../Views/announcement.php";
    }
}
