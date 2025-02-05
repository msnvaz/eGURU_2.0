<?php

namespace App\Controllers;


class StudentReportController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentReportModel();
    }

   public function ShowReport(){
    include '../src/Views/student/report.php';

   }
}