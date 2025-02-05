<?php

namespace App\Controllers\tutor;

use App\Models\tutor\AdvertisementModel;

class TutorAdvertisementController {
    private $model;

    public function __construct() {
        $this->model = new AdvertisementModel();
    }

    /**
     * Displays the advertisement gallery page with a list of ads.
     */
    public function showAdvertisementGalleryPage() {
        // Fetch all advertisements from the database
        $ads = $this->model->getAllAdvertisements();

        // Pass data to the view
        require_once __DIR__ . '/../../Views/tutor/advertisement_gallery.php';
    }

    /**
     * Handles uploading an advertisement.
     */
    public function uploadAdvertisement() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image']) && isset($_POST['description'])) {
                // Define upload directory
                $uploadDir = 'uploads/';
                $uploadPath = $uploadDir . basename($_FILES['image']['name']);

                // Ensure uploads directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Move uploaded file to the upload directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    // Sanitize description
                    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

                    // Save advertisement to the database
                    $this->model->addAdvertisement($uploadPath, $description);

                    // Redirect back to the gallery page
                    header('Location: /tutor-advertisement');
                    exit();
                } else {
                    echo "Failed to upload the image. Please try again.";
                }
            } else {
                echo "Please fill all fields and select an image.";
            }
        } else {
            // If not a POST request, show the upload form
            require_once __DIR__ . '/../../views/tutor/upload_advertisement.php';
        }
    }

    public function deleteAdvertisement()
    {
        if (isset($_POST['id'])) {
            $model = new AdvertisementModel();
            $model->deleteAdvertisementById($_POST['id']);
            header("Location: /tutor-advertisement"); // Redirect back to gallery
        }
    }

    public function updateAdvertisement()
    {
        if (isset($_POST['id']) && isset($_POST['description'])) {
            $model = new AdvertisementModel();
            $model->updateAdvertisementDescription($_POST['id'], $_POST['description']);
            header("Location: /tutor-advertisement"); // Redirect back to gallery
        }
    }
}
