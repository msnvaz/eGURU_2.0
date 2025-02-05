<?php
include_once 'Controller/UserController.php';

$userController = new UserController();

$action = $_GET['action'] ?? 'login'; // Default action is login

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userController->processLogin();
        } else {
            $userController->displayLogin();
        }
        break;
    default:
        $userController->displayLogin();
        break;
}
?>
