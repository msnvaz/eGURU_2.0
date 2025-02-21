<?php 
namespace App\Models\student;

use App\config\database;
use PDO; 


class Comment{
    private $conn;
    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function save_comment($id,$tutor_id,$name,$comment,$tutorname){
        print_r($id);
        $query = $this->conn->prepare("INSERT INTO feedback (student_id,tutor_id,student_name,comments,first_name) VALUES  (:student_id,:tutor_id,:student_name,:comments,:first_name)");

        $query->execute(['student_id' => $id, 'tutor_id' => $tutor_id, 'student_name' => $name, 'comments' => $comment,'first_name'=>$tutorname]);

        return true;
    }

    public function update_comment($comment_id, $new_comment) {
        $query = $this->conn->prepare("UPDATE feedback SET comments = :new_comment WHERE id = :id");
        $query->execute([
            'new_comment' => $new_comment,
            'id' => $comment_id
        ]);
        
        // Optional: Return the number of rows affected
        return true;
    }
    
    public function delete_comment($comment_id) {
        $query = $this->conn->prepare("DELETE FROM feedback WHERE id = :id");
        $query->execute(['id' => $comment_id]);
        
        // Optional: Return the number of rows affected
        return true;
    }

    public function get_comment(){
        $query = $this->conn->prepare("SELECT * FROM feedback");
        $query->execute();
        return $query->fetchAll();
    }


}
