<?php
namespace App\Controllers\tutor;

session_destroy();
session_start();
use App\Models\tutor\UserModel;

class TutorLoginController {
    public function showLogin() {
        $error = $_SESSION['error'] ?? '';
        unset($_SESSION['error']);
        require_once __DIR__ .'/../../Views/tutor/login.php';
    }

    public function handleLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $tutor_id = UserModel::validateUser($email, $password);

            if ($tutor_id) {
                $_SESSION['loggedin'] = true;
                $_SESSION['tutor_id'] = $tutor_id;
                $_SESSION['email'] = $email;
                header("Location: /tutor-dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Invalid email or password. Please try again.";
                header("Location: /tutor-login");
                exit;
            }
        }
    }
}
