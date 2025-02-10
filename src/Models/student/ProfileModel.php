<?php

namespace App\Models\student;
use App\config\database;

use PDO;

class ProfileModel {  // Make sure the class name is 'ProfileModel'
    private $db;

    public function __construct() {
        // Initialize PDO or database connection
        $this->db = new PDO('mysql:host=localhost;dbname=eguru_full', 'root', '');
    }

    // Method to update the profile data
    // In ProfileModel.php

public function updateProfile($data) {
    $sql = "UPDATE student_profile 
            SET name = :name,
                bio = :bio, 
                education = :education, 
                phone = :phone, 
                email = :email, 
                interests = :interests, 
                country = :country, 
                city_town = :city_town, 
                grade = :grade";
    
    // Add profile picture to update if it exists
    if (isset($data['profile_picture'])) {
        $sql .= ", profile_picture = :profile_picture";
    }
    
    $sql .= " WHERE student_id = :student_id";

    $stmt = $this->db->prepare($sql);
    
    $params = [
        ':name' => $data['name'],
        ':bio' => $data['bio'],
        ':education' => $data['education'],
        ':phone' => $data['phone'],
        ':email' => $data['email'],
        ':interests' => $data['interests'],
        ':country' => $data['country'],
        ':city_town' => $data['city_town'],
        ':grade' => $data['grade'],
        ':student_id' => $data['student_id']
    ];
    
    if (isset($data['profile_picture'])) {
        $params[':profile_picture'] = $data['profile_picture'];
    }

    return $stmt->execute($params);
}

public function createProfile($data) {
    $fields = [
        'student_id', 'name', 'bio', 'education', 'phone', 
        'email', 'interests', 'country', 'city_town', 'grade'
    ];
    
    if (isset($data['profile_picture'])) {
        $fields[] = 'profile_picture';
    }
    
    $sql = "INSERT INTO student_profile (" . implode(', ', $fields) . ") 
            VALUES (:" . implode(', :', $fields) . ")";

    $stmt = $this->db->prepare($sql);
    
    $params = array_intersect_key($data, array_flip($fields));
    if (isset($data['profile_picture'])) {
        $params['profile_picture'] = $data['profile_picture'];
    }
    
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
    

    // Method to fetch profile data by student ID
    public function getProfileByStudentId($studentId) {
        $sql = "SELECT * FROM student_profile WHERE student_id = :student_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':student_id' => $studentId]);

        return $stmt->fetch();
    }
}
