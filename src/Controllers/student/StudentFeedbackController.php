<?php

namespace App\Controllers\student;

use App\Models\student\Comment;

class StudentFeedbackController{
    private $model1;
    private $data;


    public function __construct(){
        $this-> model1 = new Comment();
        $this->data = $this->model1->get_comment();
      
    }

   public function ShowFeedback(){
    $data = $this->data;
    include '../src/Views/student/feedback.php';

   }

   public function save_comments(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_SESSION['student_id'];
        $studentname = $_SESSION['student_name'];
        $tutor_id = $_POST['tutor_id'];
        $tutor_name = $_POST["tutor_name"];
        $comment = $_POST['comments'];
        $succes = $this->model1->save_comment($id,$tutor_id,$studentname,$comment,$tutor_name);
        if($succes){
            header("Location: /student-feedback");
            exit;
            
        }

    }
   }

   public function update_comments(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        print_r($_POST);
        $comment = $_POST['comments'];
        $id = $_POST['id'];
        $success = $this->model1->update_comment($id,$comment);
        if($success){
            header("Location: /student-feedback");
            exit;
            
        }

   }}

   public function delete_comments(){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $success = $this->model1->delete_comment($id);
        if($success){
            header("Location: /student-feedback");
            exit;
            
        }

   }
   }
}