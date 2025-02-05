<?php

namespace App\Models;

class Tutor
{
    public $name;
    public $tutorID;

    public function __construct($name, $tutorID)
    {
        $this->name = $name;
        $this->tutorID = $tutorID;
    }
}