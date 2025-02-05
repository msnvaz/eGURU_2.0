<?php

namespace App\Controllers;


class StudentLogoutController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentLogoutModel();
    }

   public function ShowLogout(){
    include '../src/Views/index.php';

   }
}