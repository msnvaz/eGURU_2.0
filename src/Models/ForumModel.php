<?php

namespace App\Models;

class ForumModel {
    private $conn;

    public function __construct() {
        $this->conn = mysqli_connect("localhost", "root", "", "eguru");
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    /**
     * Insert a new comment or reply.
     */
    public function insertComment($name, $comment, $date, $reply_id = 0) {
        // Insert into student_forum table, using the primary key `forum_id` which auto-increments
        $stmt = $this->conn->prepare("INSERT INTO student_forum (name, comment, date, reply_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $comment, $date, $reply_id);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * Get comments or replies by parent ID.
     * Default reply_id = 0 retrieves top-level comments.
     */
    public function getComments($reply_id = 0) {
        // Adjust SQL query to handle the `forum_id` as the primary key, ensuring that the query fetches based on `reply_id`
        $stmt = $this->conn->prepare("SELECT forum_id, name, comment, date, reply_id FROM student_forum WHERE reply_id = ? ORDER BY date ASC");
        $stmt->bind_param("i", $reply_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }

        $stmt->close();
        return $comments;
    }

    /**
     * Close DB connection.
     */
    public function closeConnection() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
?>
