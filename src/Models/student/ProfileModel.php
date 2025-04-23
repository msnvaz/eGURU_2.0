<?php

namespace App\Models\student;
use App\config\database;

use PDO;

class ProfileModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=eguru', 'root', '');
    }

    public function updateProfile($data) {
        $sql = "UPDATE student_profile 
                SET bio = :bio, 
                    education = :education, 
                    interests = :interests, 
                    country = :country, 
                    city_town = :city_town,
                    student_grade = :student_grade,
                    student_profile_photo = :student_profile_photo
                WHERE student_id = :student_id";
    
        $stmt = $this->db->prepare($sql);
        
        $params = [
            ':bio' => $data['bio'],
            ':education' => $data['education'],
            ':interests' => $data['interests'],
            ':country' => $data['country'],
            ':city_town' => $data['city_town'],
            ':student_grade' => $data['student_grade'],
            ':student_profile_photo' => $data['student_profile_photo'],
            ':student_id' => $data['student_id']
        ];
    
        return $stmt->execute($params);
    }
    
    public function createProfile($data) {
        $fields = [
            'student_id', 'bio', 'education', 'interests', 'country', 'city_town', 'student_grade', 'student_profile_photo'
        ];
        
        $sql = "INSERT INTO student_profile (" . implode(', ', $fields) . ") 
                VALUES (:" . implode(', :', $fields) . ")";
    
        $stmt = $this->db->prepare($sql);
        
        $params = array_intersect_key($data, array_flip($fields));
        
        return $stmt->execute($params);
    }

    public function checkid($student_id) {
        $sql = "SELECT * FROM student_profile WHERE student_id = :student_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $student_id]);
        $result = $stmt->fetchAll();
        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
     }

    public function getProfileByStudentId($studentId) {
        $sql = "SELECT * FROM student_profile WHERE student_id = :student_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getStudentContactInfo($studentId) {
        $sql = "SELECT student_phonenumber, student_email FROM student WHERE student_id = :student_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function updateStudentGrade($studentId, $grade) {
        $sql = "UPDATE student SET student_grade = :student_grade WHERE student_id = :student_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':student_grade' => $grade,
            ':student_id' => $studentId
        ]);
    }
    
    public function deleteProfile($studentId) {
        $this->db->beginTransaction();
        try {
            $sql = "UPDATE student_profile SET profile_status = 'unset' WHERE student_id = :student_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':student_id' => $studentId]);

            $sql = "UPDATE student SET student_status = 'unset' WHERE student_id = :student_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':student_id' => $studentId]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}