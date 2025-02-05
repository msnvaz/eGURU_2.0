<?php

namespace App\Models;

use App\Config\Database;
use PDO;

class Student_profile {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    /**
     * Inserts a new student record into the database.
     */
    public function student_signup($firstname, $lastname, $email, $password, $dateofbirth, $phonenumber) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT); // Hash the password
        $query = $this->conn->prepare("
            INSERT INTO student (firstname, lastname, email, password, phonenumber, dateofbirth) 
            VALUES (:firstname, :lastname, :email, :password, :phonenumber, :dateofbirth)
        ");
        $query->execute([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $hashedPassword,
            'phonenumber' => $phonenumber,
            'dateofbirth' => $dateofbirth
        ]);

        return [
            'id' => $this->conn->lastInsertId(),
            'firstname' => $firstname,
            'lastname' => $lastname
        ];
    }

    /**
     * Checks if an email exists in the database.
     */
    public function check_email($email) {
        $query = $this->conn->prepare("SELECT * FROM student WHERE email = :email");
        $query->execute(['email' => $email]);
        return $query->rowCount() > 0; // Returns true if the email exists
    }

    /**
     * Logs in a student by verifying email and password.
     */
    public function student_login($email, $password) {
        $query = $this->conn->prepare("SELECT * FROM student WHERE email = :email");
        $query->execute(['email' => $email]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            // Verify the password
            if (password_verify($password, $data['password'])) {
                return $data; // Login successful
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