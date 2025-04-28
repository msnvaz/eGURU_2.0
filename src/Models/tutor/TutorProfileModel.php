<?php

namespace App\Models\tutor;

use App\config\database;
use PDO;

class TutorProfileModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function updateProfile($data) {
        try {
            
            $this->conn->beginTransaction();
        
            $sqlProfile = "UPDATE tutor_profile 
                           SET bio = :bio, 
                               education = :education, 
                               specialization = :specialization,
                               experience = :experience, 
                               country = :country, 
                               city_town = :city_town";
    
    
            $sqlProfile .= " WHERE tutor_id = :tutor_id";
    
            $stmtProfile = $this->conn->prepare($sqlProfile);
    
            $paramsProfile = [
                ':bio' => $data['bio'],
                ':education' => $data['education'],
                ':specialization' => $data['specialization'],
                ':experience' => $data['experience'],
                ':country' => $data['country'],
                ':city_town' => $data['city_town'],
                ':tutor_id' => $data['tutor_id']
            ];
    
            
    
            $stmtProfile->execute($paramsProfile);
    
            
            $sqlTutor = "UPDATE tutor 
                         SET tutor_first_name = :tutor_first_name,
                             tutor_last_name = :tutor_last_name,
                             tutor_contact_number = :tutor_contact_number,
                             tutor_profile_photo = :tutor_profile_photo,
                             tutor_email = :tutor_email,
                             tutor_DOB = :tutor_DOB,
                             tutor_NIC = :tutor_NIC";
    
            
    
            $sqlTutor .= " WHERE tutor_id = :tutor_id";
    
            $stmtTutor = $this->conn->prepare($sqlTutor);
    
            $paramsTutor = [
                ':tutor_first_name' => $data['tutor_first_name'],
                ':tutor_last_name' => $data['tutor_last_name'],
                ':tutor_contact_number' => $data['tutor_contact_number'],
                ':tutor_email' => $data['tutor_email'],
                ':tutor_DOB' => $data['tutor_DOB'],
                ':tutor_NIC' => $data['tutor_NIC'],
                ':tutor_profile_photo' => $data['tutor_profile_photo'],
                ':tutor_id' => $data['tutor_id']
            ];
    
           
    
            $stmtTutor->execute($paramsTutor);
    
           
            $this->conn->commit();
            return true;
    
        } catch (\Exception $e) {
            
            $this->conn->rollBack();
            throw $e;
        }
    }
    
    
    
    public function createProfile($data) {
        try {
            
            $this->conn->beginTransaction();
    
                    $sqlTutor = "UPDATE tutor 
                    SET tutor_first_name = :tutor_first_name,
                        tutor_last_name = :tutor_last_name,
                        tutor_contact_number = :tutor_contact_number,
                        tutor_profile_photo = :tutor_profile_photo,
                        tutor_email = :tutor_email,
                        tutor_DOB = :tutor_DOB,
                        tutor_NIC = :tutor_NIC";

                       

                        $sqlTutor .= " WHERE tutor_id = :tutor_id";

                        $stmtTutor = $this->conn->prepare($sqlTutor);

                        $paramsTutor = [
                        ':tutor_first_name' => $data['tutor_first_name'],
                        ':tutor_last_name' => $data['tutor_last_name'],
                        ':tutor_contact_number' => $data['tutor_contact_number'],
                        ':tutor_email' => $data['tutor_email'],
                        ':tutor_DOB' => $data['tutor_DOB'],
                        ':tutor_NIC' => $data['tutor_NIC'],
                        ':tutor_profile_photo' => $data['tutor_profile_photo'],
                        ':tutor_id' => $data['tutor_id']
                        ];

                        

                        $stmtTutor->execute($paramsTutor);
                
            
    
            
            $fields = [
                'tutor_id', 'bio', 'education', 'specialization', 'experience', 'country', 'city_town'
            ];
    
            $sql = "INSERT INTO tutor_profile (" . implode(', ', $fields) . ") 
                    VALUES (:" . implode(', :', $fields) . ")";
            
            $stmt = $this->conn->prepare($sql);
            $params = array_intersect_key($data, array_flip($fields));
            $stmt->execute($params);
    
            
            $this->conn->commit();
            return true;
    
        } catch (\Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }
    

    public function checkid($tutor_id) {
        $sql = "SELECT * FROM tutor_profile WHERE tutor_id = :tutor_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tutor_id' => $tutor_id]);
        $result = $stmt->fetchAll();
        if(count($result) > 0) {
            return true;
        } else {
            return false;
        }
     }

    public function getProfileByTutorId($tutorId) {
        $sql = "SELECT * FROM tutor_profile WHERE tutor_id = :tutor_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tutor_id' => $tutorId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getTutorInfo($tutorId) {
        $sql = "SELECT tutor_contact_number, tutor_email, tutor_first_name, tutor_last_name, tutor_profile_photo, tutor_NIC, tutor_DOB FROM tutor WHERE tutor_id = :tutor_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':tutor_id' => $tutorId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function deleteProfile($tutorId) {
        $this->conn->beginTransaction();
        try {
            $sql = "UPDATE tutor_profile SET profile_status = 'unset' WHERE tutor_id = :tutor_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tutor_id' => $tutorId]);

            $sql = "UPDATE tutor SET tutor_status = 'unset' WHERE tutor_id = :tutor_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':tutor_id' => $tutorId]);

            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function getTutorSubjects($tutorId) {
        $query = "
            SELECT s.subject_name 
            FROM tutor_subject ts
            JOIN subject s ON ts.subject_id = s.subject_id
            WHERE ts.tutor_id = :tutor_id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutor_id', $tutorId);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'subject_name');
    }
    
    public function getTutorGrades($tutorId) {
        $query = "SELECT grade FROM tutor_grades WHERE tutor_id = :tutor_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutor_id', $tutorId);
        $stmt->execute();
        return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'grade');
    }

    public function getAllSubjects() {
        $stmt = $this->conn->prepare("SELECT subject_id, subject_name FROM subject");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function updateTutorSubjects($tutorId, $subjects) {
        
        $this->conn->prepare("DELETE FROM tutor_subject WHERE tutor_id = ?")->execute([$tutorId]);
    
        
        $stmt = $this->conn->prepare("INSERT INTO tutor_subject (tutor_id, subject_id) VALUES (?, ?)");
        foreach ($subjects as $subjectId) {
            $stmt->execute([$tutorId, $subjectId]);
        }
    }
    
    public function updateTutorGrades($tutorId, $grades) {
        $this->conn->prepare("DELETE FROM tutor_grades WHERE tutor_id = ?")->execute([$tutorId]);
    
        $stmt = $this->conn->prepare("INSERT INTO tutor_grades (tutor_id, grade) VALUES (?, ?)");
        foreach ($grades as $grade) {
            $stmt->execute([$tutorId, $grade]);
        }
    }
    
}