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

    public function getAllAdvertisements() {
        $query = $this->conn->query("SELECT * FROM advertisements ORDER BY created_at DESC");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAdvertisement($imagePath, $description) {
        $query = $this->conn->prepare("INSERT INTO advertisements (image_path, description) VALUES (:image_path, :description)");
        $query->execute(['image_path' => $imagePath, 'description' => $description]);
    }

    public function deleteAdvertisementById($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM advertisements WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function updateAdvertisementDescription($id, $description)
    {
        $stmt = $this->conn->prepare("UPDATE advertisements SET description = :description WHERE id = :id");
        $stmt->execute(['description' => $description, 'id' => $id]);
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