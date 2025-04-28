<?php

namespace App\Models\tutor;

use App\Config\database;
use PDO;

class AdvertisementModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllAdvertisements($tutorId) {
        $status = 'set'; 
        $query = "SELECT * FROM tutor_advertisement WHERE tutor_id = :tutorId AND ad_status = :status ORDER BY ad_created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tutorId', $tutorId);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function addAdvertisement($imagePath, $description, $tutorId) {
        $query = $this->conn->prepare("INSERT INTO tutor_advertisement (tutor_id, ad_display_pic, ad_description) VALUES (:tutor_id, :image_path, :description)");
        $query->execute(['tutor_id' => $tutorId, 'image_path' => $imagePath, 'description' => $description]);
    }

    public function deleteAdvertisementById($id) {
        $query = "UPDATE tutor_advertisement SET ad_status = :status WHERE ad_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':id' => $id,
            ':status' => 'unset'
        ]);
    }
    

    public function updateAdvertisementDescription($id, $description)
    {
        $stmt = $this->conn->prepare("UPDATE tutor_advertisement SET ad_description = :description WHERE ad_id = :id");
        $stmt->execute(['description' => $description, 'id' => $id]);
    }

    public function updateTutorAd($adId, $tutorId) {
        $query = "UPDATE tutor SET tutor_ad_id = :ad_id WHERE tutor_id = :tutor_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ad_id', $adId);
        $stmt->bindParam(':tutor_id', $tutorId);
        $stmt->execute();
    }
    

}



// database code
/**CREATE TABLE advertisements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_path VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 */