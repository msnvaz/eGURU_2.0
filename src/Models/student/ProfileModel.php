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
        $sqlProfile = "UPDATE student_profile 
                    SET bio = :bio, 
                        education = :education, 
                        interests = :interests, 
                        country = :country, 
                        city_town = :city_town,
                        student_grade = :student_grade
                    WHERE student_id = :student_id";
        
        $stmtProfile = $this->db->prepare($sqlProfile);
        
        $paramsProfile = [
            ':bio' => $data['bio'],
            ':education' => $data['education'],
            ':interests' => $data['interests'],
            ':country' => $data['country'],
            ':city_town' => $data['city_town'],
            ':student_grade' => $data['student_grade'],
            ':student_id' => $data['student_id']
        ];
        
        $profileUpdated = $stmtProfile->execute($paramsProfile);
        
        $sqlStudent = "UPDATE student
                    SET student_profile_photo = :student_profile_photo
                    WHERE student_id = :student_id";
        
        $stmtStudent = $this->db->prepare($sqlStudent);
        
        $paramsStudent = [
            ':student_profile_photo' => $data['student_profile_photo'],
            ':student_id' => $data['student_id']
        ];
        
        $photoUpdated = $stmtStudent->execute($paramsStudent);
        
        return $profileUpdated && $photoUpdated;
    }
    
    public function updateChangedFields($data, $photoUpdated = false) {
        try {
            $this->db->beginTransaction();
            
            // Update profile fields if there are any to update
            $profileFields = ['bio', 'education', 'interests', 'country', 'city_town', 'student_grade'];
            $updateProfileFields = array_intersect_key($data, array_flip($profileFields));
            
            if (!empty($updateProfileFields)) {
                $sqlParts = [];
                $params = [':student_id' => $data['student_id']];
                
                foreach ($updateProfileFields as $field => $value) {
                    $sqlParts[] = "$field = :$field";
                    $params[":$field"] = $value;
                }
                
                $sqlProfile = "UPDATE student_profile SET " . implode(', ', $sqlParts) . " WHERE student_id = :student_id";
                $stmtProfile = $this->db->prepare($sqlProfile);
                $stmtProfile->execute($params);
            }
            
            // Update photo if it was changed
            if ($photoUpdated && isset($data['student_profile_photo'])) {
                $sqlStudent = "UPDATE student SET student_profile_photo = :student_profile_photo WHERE student_id = :student_id";
                $stmtStudent = $this->db->prepare($sqlStudent);
                $stmtStudent->execute([
                    ':student_profile_photo' => $data['student_profile_photo'],
                    ':student_id' => $data['student_id']
                ]);
            }
            
            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
    
    public function getStudentProfilePhoto($studentId) {
        try {
            $query = "SELECT student_profile_photo FROM student WHERE student_id = :student_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['student_profile_photo'];
        } catch (\PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return null;
        }
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