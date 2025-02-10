<?php

namespace App\Models\student;

use App\Config\Database;
use PDO;

class Student_profile {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function student_signup($firstname, $lastname, $email, $password, $dateofbirth, $phonenumber) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $initial_points = 0; // Initial points for new signup

        $query = $this->conn->prepare("
            INSERT INTO student (firstname, lastname, email, password, phonenumber, dateofbirth, points) 
            VALUES (:firstname, :lastname, :email, :password, :phonenumber, :dateofbirth, :points)
        ");
        $query->execute([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $hashedPassword,
            'phonenumber' => $phonenumber,
            'dateofbirth' => $dateofbirth,
            'points' => $initial_points
        ]);

        return [
            'id' => $this->conn->lastInsertId(),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'points' => $initial_points
        ];
    }

    // Existing methods remain the same
    public function check_email($email) {
        $query = $this->conn->prepare("SELECT * FROM student WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->rowCount() > 0;
    }

    public function student_login($email, $password) {
        $query = $this->conn->prepare("SELECT * FROM student WHERE email = :email");
        $query->execute(['email' => $email]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            if (password_verify($password, $data['password'])) {
                return $data;
            } else {
                $_SESSION['login_error'] = "Invalid password";
                return false;
            }
        } else {
            $_SESSION['login_error'] = "Email not found";
            return false;
        }
    }
}