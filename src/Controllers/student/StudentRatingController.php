<?php

namespace App\Controllers\student;


class StudentRatingController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentRatingModel();
    }

   public function ShowRating(){
    include '../src/Views/student/rating.php';

   }
}