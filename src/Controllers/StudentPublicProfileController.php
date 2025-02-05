<?php

namespace App\Controllers;


class StudentPublicProfileController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentPublicProfileModel();
    }

   public function ShowPublicprofile(){
    include '../src/Views/student/viewprofile.php';

   }
}