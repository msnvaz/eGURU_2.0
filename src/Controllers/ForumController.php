<?php

namespace App\Controllers;

use App\Models\ForumModel;

class ForumController {
    private $forumModel;

    public function __construct($db) {
        $this->forumModel = new ForumModel($db);
    }

    public function showForum() {
        $messages = $this->forumModel->getAllMessages();
        include 'views/forum.php';
    }
}
