<?php

namespace App\Controllers;


class StudentFindtutorController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentFindtutorModel();
    }

   public function ShowFindtutor(){
    include '../src/Views/student/findtutor.php';

   }
}