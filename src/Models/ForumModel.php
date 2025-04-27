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

    
    public function insertComment($name, $comment, $date, $reply_id = 0) {
        $stmt = $this->conn->prepare("INSERT INTO student_forum (name, comment, date, reply_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $comment, $date, $reply_id);
        $stmt->execute();
        $stmt->close();
    }

   
    public function getComments($reply_id = 0) {
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

    
    public function closeConnection() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
?>
