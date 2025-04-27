<?php

namespace App\Controllers;

use App\Models\AdvertisementModel;

class AdvertisementController {
    private $model;

    public function __construct() {
        $this->model = new AdvertisementModel();
    }

    
    public function showAdvertisementGalleryPage() {
        $ads = $this->model->getAllAdvertisements();

        require_once __DIR__ . '/../Views/advertisement_gallery.php';
    }

   
    public function uploadAdvertisement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image']) && isset($_POST['description'])) {
                $uploadDir = 'uploads/';
                $uploadPath = $uploadDir . basename($_FILES['image']['name']);

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

                    $this->model->addAdvertisement($uploadPath, $description);

                    header('Location: /advertisement');
                    exit();
                } else {
                    echo "Failed to upload the image. Please try again.";
                }
            } else {
                echo "Please fill all fields and select an image.";
            }
        } else {
            require_once __DIR__ . '/../views/upload_advertisement.php';
        }
    }

    public function deleteAdvertisement()
    {
        if (isset($_POST['id'])) {
            $model = new AdvertisementModel();
            $model->deleteAdvertisementById($_POST['id']);
            header("Location: /advertisement"); 
        }
    }

    public function updateAdvertisement()
    {
        if (isset($_POST['id']) && isset($_POST['description'])) {
            $model = new AdvertisementModel();
            $model->updateAdvertisementDescription($_POST['id'], $_POST['description']);
            header("Location: /advertisement"); // Redirect back to gallery
        }
    }
}
