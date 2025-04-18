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
            // Begin transaction
            $this->conn->beginTransaction();
    
            // Handle profile photo upload if provided
          /*  $profilePhotoPath = null;
            if (isset($data['profile-image']) && $data['profile-image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/images/tutors/'; // Adjusted relative path
                $fileName = basename($data['profile-image']['name']);
                $targetFilePath = $uploadDir . $fileName;
    
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
    
                if (move_uploaded_file($data['profile-image']['tmp_name'], $targetFilePath)) {
                    $profilePhotoPath = '/images/tutors/' . $fileName;
                }
            }*/
    
            // Update tutor_profile table
            $sqlProfile = "UPDATE tutor_profile 
                           SET bio = :bio, 
                               education = :education, 
                               specialization = :specialization,
                               experience = :experience, 
                               country = :country, 
                               city_town = :city_town";
    
            /*if ($profilePhotoPath !== null) {
                $sqlProfile .= ", tutor_profile_photo = :profile_photo";
            }*/
    
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
    
            /*if ($profilePhotoPath !== null) {
                $paramsProfile[':profile_photo'] = $profilePhotoPath;
            }*/
    
            $stmtProfile->execute($paramsProfile);
    
            // Update tutor table
            $sqlTutor = "UPDATE tutor 
                         SET tutor_first_name = :tutor_first_name,
                             tutor_last_name = :tutor_last_name,
                             tutor_contact_number = :tutor_contact_number,
                             tutor_profile_photo = :tutor_profile_photo,
                             tutor_email = :tutor_email,
                             tutor_DOB = :tutor_DOB,
                             tutor_NIC = :tutor_NIC";
    
            /*if ($profilePhotoPath !== null) {
                $sqlTutor .= ", tutor_profile_photo = :tutor_profile_photo";
            }*/
    
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
    
           /* if ($profilePhotoPath !== null) {
                $paramsTutor[':tutor_profile_photo'] = $profilePhotoPath;
            }*/
    
            $stmtTutor->execute($paramsTutor);
    
            // Commit transaction
            $this->conn->commit();
            return true;
    
        } catch (\Exception $e) {
            // Roll back transaction on error
            $this->conn->rollBack();
            throw $e;
        }
    }
    
    
    
    public function createProfile($data) {
        try {
            // Begin transaction
            $this->conn->beginTransaction();
    
            // 1. update tutor table
    
                    // Update tutor table
                    $sqlTutor = "UPDATE tutor 
                    SET tutor_first_name = :tutor_first_name,
                        tutor_last_name = :tutor_last_name,
                        tutor_contact_number = :tutor_contact_number,
                        tutor_profile_photo = :tutor_profile_photo,
                        tutor_email = :tutor_email,
                        tutor_DOB = :tutor_DOB,
                        tutor_NIC = :tutor_NIC";

                        /*if ($profilePhotoPath !== null) {
                        $sqlTutor .= ", tutor_profile_photo = :tutor_profile_photo";
                        }*/

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

                        /* if ($profilePhotoPath !== null) {
                        $paramsTutor[':tutor_profile_photo'] = $profilePhotoPath;
                        }*/

                        $stmtTutor->execute($paramsTutor);
                
            
    
            // 2. Insert new record into tutor_profile table
            $fields = [
                'tutor_id', 'bio', 'education', 'specialization', 'experience', 'country', 'city_town'
            ];
    
            $sql = "INSERT INTO tutor_profile (" . implode(', ', $fields) . ") 
                    VALUES (:" . implode(', :', $fields) . ")";
            
            $stmt = $this->conn->prepare($sql);
            $params = array_intersect_key($data, array_flip($fields));
            $stmt->execute($params);
    
            // Commit transaction
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
        // Delete old
        $this->conn->prepare("DELETE FROM tutor_subject WHERE tutor_id = ?")->execute([$tutorId]);
    
        // Insert new
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