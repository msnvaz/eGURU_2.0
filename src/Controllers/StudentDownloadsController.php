<?php

namespace App\Controllers;


class StudentDownloadsController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentDownloadsModel();
    }

   public function ShowDownloads(){
    include '../src/Views/student/downloads.php';

   }
}