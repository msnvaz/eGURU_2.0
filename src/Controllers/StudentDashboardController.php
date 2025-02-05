<?php
namespace App\Controllers;


class StudentDashboardController{
    private $model;

    public function __construct(){
        // $this-> model = new StudentDashboardModel();
    }

   public function showStudentDashboardPage(){
    include '../src/Views/student/dashboard.php';

   }
}
