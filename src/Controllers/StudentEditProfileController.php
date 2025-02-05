<?php

namespace App\Controllers;


class StudentEditProfileController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentDownloadsModel();
    }

   public function ShowEditProfile(){
    include '../src/Views/student/profile.php';

   }
}