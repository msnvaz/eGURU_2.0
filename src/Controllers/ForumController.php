<?php
namespace App\Controllers;

use App\Models\ForumModel;

class ForumController {
    public function showForumMessages() {
        $forumModel = new ForumModel();

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $comment = $_POST['comment'] ?? '';
            $replyId = (int)($_POST['reply_id'] ?? 0);
            $date = date("Y-m-d H:i:s");

            // Insert the new comment or reply
            $forum_id = $forumModel->insertComment($name, $comment, $date, $replyId);  // Get the inserted forum_id

            // If the request is an AJAX request (typically from JavaScript for inline updates)
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                // Fetch the latest comments and return the updated HTML for the comments section only
                $mainComments = $forumModel->getComments(0); // Get top-level comments
                include_once __DIR__ . '/../Views/forum.php'; // This file should include only the comments section
                return; // End the method after responding with the new comments
            }

            // Non-AJAX fallback (original behavior) - redirect to the main forum page
            header("Location: /forum");
            exit;
        }

        // Default GET request - load the full page with all comments
        $mainComments = $forumModel->getComments(0); // Get top-level comments
        include_once __DIR__ . '/../Views/forum.php'; // This should load the entire forum page, including comments and the comment form
    }
}
?>
