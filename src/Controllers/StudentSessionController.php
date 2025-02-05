<?php

namespace App\Controllers;


class StudentSessionController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentSessionModel();
    }

   public function ShowSession(){
    include '../src/Views/student/session.php';

   }
}