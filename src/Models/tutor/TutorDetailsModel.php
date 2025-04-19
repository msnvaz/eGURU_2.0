<?php

namespace App\Models\tutor;

use App\config\database;
use PDO;

class TutorDetailsModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Method to get tutor details by ID
    public function getTutorDetails($tutorId)
    {
        try {
            // Prepare SQL query to retrieve tutor details
            $query = "SELECT * FROM tutor WHERE tutor_id = :tutorId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tutorId', $tutorId, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch tutor details
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle any database connection errors
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Method to validate tutor credentials
    public function validateTutor($email, $password) {
        try {
            $query = "SELECT tutor_id, tutor_password 
                    FROM tutor 
                    WHERE tutor_email = :tutor_email 
                    AND tutor_status IN ('set', 'requested')";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tutor_email', $email);
            $stmt->execute();

            $tutor = $stmt->fetch(PDO::FETCH_ASSOC);

    
            if ($tutor && ($password == $tutor['tutor_password'])) {
                // Credentials valid, update last login and log status
                $updateQuery = "UPDATE tutor SET tutor_last_login = :last_login, tutor_log = 'online' WHERE tutor_id = :tutor_id";
                $updateStmt = $this->conn->prepare($updateQuery);
                $currentDateTime = date('Y-m-d H:i:s');
                $updateStmt->bindParam(':last_login', $currentDateTime);
                $updateStmt->bindParam(':tutor_id', $tutor['tutor_id']);
                $updateStmt->execute();
    
                return $tutor; // Return tutor details including ID
            } else {
                echo "Login failed: Incorrect email or password for " . $email;
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateTutorLogStatus($tutorId, $status) {
        try {
            $query = "UPDATE tutor SET tutor_log = :status WHERE tutor_id = :tutor_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':tutor_id', $tutorId);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Failed to update tutor log status: " . $e->getMessage());
        }
    }
    
    
    

    public function createTutor($firstName, $lastName, $email, $birth_date, $password, $nic, $contactNumber, $highest_qualification) {
        try {
            $registrationDate = date('Y-m-d H:i:s'); // Current timestamp
            $status = "requested";
            $prof_pic = "default_tutor.png";
            $query = "INSERT INTO tutor (
                        tutor_first_name, tutor_last_name, tutor_email, tutor_password,
                        tutor_DOB, tutor_NIC, tutor_contact_number, tutor_registration_date,
                        tutor_qualification_proof, tutor_status, tutor_profile_photo
                      ) VALUES (
                        :tutor_first_name, :tutor_last_name, :tutor_email, :tutor_password,
                        :tutor_DOB, :tutor_NIC, :tutor_contact_number, :tutor_registration_date,
                        :tutor_qualification_proof, :tutor_status, :tutor_profile_photo
                      )";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':tutor_first_name', $firstName);
            $stmt->bindParam(':tutor_last_name', $lastName);
            $stmt->bindParam(':tutor_email', $email);
            $stmt->bindParam(':tutor_password', $password);
            $stmt->bindParam(':tutor_DOB', $birth_date);
            $stmt->bindParam(':tutor_NIC', $nic);
            $stmt->bindParam(':tutor_contact_number', $contactNumber);
            $stmt->bindParam(':tutor_registration_date', $registrationDate);
            $stmt->bindParam(':tutor_qualification_proof', $highest_qualification);
            $stmt->bindParam(':tutor_status', $status);
            $stmt->bindParam(':tutor_profile_photo', $prof_pic);

            $stmt->execute();
        } catch (PDOException $e) {
            throw new \Exception("Database Error: " . $e->getMessage());
        }
    }
    
    

}
