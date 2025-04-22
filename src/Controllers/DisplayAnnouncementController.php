<?php
namespace App\Controllers;

use App\Models\DisplayAnnouncementModel;
use App\Config\Database;

class DisplayAnnouncementController {
    private $announcementModel;

    public function __construct() {
        $db = new Database();
        $this->announcementModel = new DisplayAnnouncementModel($db->connect());
    }

    public function displayAnnouncements($offset = 0) {
        return $this->announcementModel->getAnnouncements($offset);
    }

    public function loadMoreAnnouncements() {
        $offset = (int)($_POST['offset'] ?? 0);
        $moreAnnouncements = $this->displayAnnouncements($offset);
        echo json_encode($moreAnnouncements);
    }
    
    
}
