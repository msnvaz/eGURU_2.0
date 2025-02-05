<?php

namespace App\Controllers;

use App\Controller;
use App\Models\Tutor;

class HomeController extends Controller
{    public function index()
    {
        $tutors = [
            new Tutor('James', '0001'),
            new Tutor('William', '0002'),
            new Tutor('Sahara', '0003')
        ];
        $this->render('index', ['tutors' => $tutors]);
    }
}