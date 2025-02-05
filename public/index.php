<?php
// At the very top of your index.php or in a separate bootstrap file
session_start();
require '../vendor/autoload.php';

$router = require '../src/Routes/index.php';