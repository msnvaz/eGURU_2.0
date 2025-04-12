<?php
use App\Models\ForumModel;

class ForumController
{
    private $forum;

    public function __construct($db)
    {
        $this->forum = new Forum($db);
    }

    public function index()
{
    $messages = $this->forum->getAllMessagesWithStudentName();
    var_dump($messages); // Debug line
    require 'Views/forum.php';
}

}
