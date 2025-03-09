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

    public function student_signup($student_first_name, $student_last_name, $student_email, $student_password, $student_DOB, $student_phonenumber) {
        $hashedPassword = password_hash($student_password, PASSWORD_BCRYPT);
        $student_points = 0; // Initial points for new signup

        $query = $this->conn->prepare("
            INSERT INTO student (student_first_name, student_last_name, student_email, student_password, student_phonenumber, student_DOB, student_points) 
            VALUES (:student_first_name, :student_last_name, :student_email, :student_password, :student_phonenumber, :student_DOB, :student_points)
        ");
        $query->execute([
            'student_first_name' => $student_first_name,
            'student_last_name' => $student_last_name,
            'student_email' => $student_email,
            'student_password' => $hashedPassword,
            'student_phonenumber' => $student_phonenumber,
            'student_DOB' => $student_DOB,
            'student_points' => $student_points
        ]);

        return [
            'student_id' => $this->conn->lastInsertId(),
            'student_first_name' => $student_first_name,
            'student_last_name' => $student_last_name,
            'student_points' => $student_points
        ];
    }

    // Existing methods remain the same
    public function check_email($student_email) {
        $query = $this->conn->prepare("SELECT * FROM student WHERE student_email = :student_email");
        $query->execute(['student_email' => $student_email]);
        return $query->rowCount() > 0;
    }

    public function student_login($student_email, $student_password) {
        $query = $this->conn->prepare("SELECT * FROM student WHERE student_email = :student_email");
        $query->execute(['student_email' => $student_email]);
        $data = $query->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            if ($data['student_status'] === 'unset') {
                $_SESSION['login_error'] = "Your account has been deleted. Please sign up again.";
                return false;
            }

            if (password_verify($student_password, $data['student_password'])) {
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