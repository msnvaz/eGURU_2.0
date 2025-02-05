<?php

namespace App\Controllers;


class StudentPaymentController{
    private $model;

    public function _construct(){
        // $this-> model = new StudentPaymentModel();
    }

   public function ShowPayment(){
    include '../src/Views/student/payments.php';

   }
}