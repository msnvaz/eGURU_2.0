<?php
namespace App\Controllers;
use App\Models\ForumModel;
use App\Controller;

class ForumController {
    private $forumModel;

    public function __construct($db) {
        $this->forumModel = new ForumModel($db);
    }

    public function showForum() {
        $messages = $this->forumModel->getAllMessages();
        include 'Views/forum.php';
    }
}
?>
