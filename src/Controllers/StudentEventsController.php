<?php

namespace App\Controllers;


class StudentEventsController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentEventsModel();
    }

   public function ShowEvents(){
    include '../src/Views/student/newevent.php';

   }
}