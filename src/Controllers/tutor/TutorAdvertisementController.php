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

        session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
    
        $tutorData = null;
    
        $ads = [];
        
    
        // Fetch tutor details if tutor_id exists in session
        if (isset($_SESSION['tutor_id'])) {
            $tutorId = $_SESSION['tutor_id'];

            // Fetch all advertisements from the database
            $ads = $this->model->getAllAdvertisements($tutorId);

        }

        // Pass data to the view
        require_once __DIR__ . '/../../Views/tutor/advertisement_gallery.php';
    }

    /**
     * Handles uploading an advertisement.
     */
    public function uploadAdvertisement() {

        session_start(); // Ensure session is started

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image']) && isset($_POST['description'])) {
                // Define upload directory
                $uploadDir = './uploads/tutor_ads/';
                $file_name = basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $file_name;

                // Ensure uploads directory exists
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                // Move uploaded file to the upload directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    // Sanitize description
                    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

                    // Save advertisement to the database
                    if (isset($_SESSION['tutor_id'])) {
                        $tutorId = $_SESSION['tutor_id'];
            
                        $this->model->addAdvertisement($file_name, $description, $tutorId);
                    }
                    
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

    public function selectAd() {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adId = $_POST['ad_id'];
            $tutorId = $_SESSION['tutor_id'];

            // If the same ad is clicked again, unselect it
            if ($_SESSION['selected_ad_id'] == $adId) {
                $this->model->updateTutorAd(null, $tutorId);
                unset($_SESSION['selected_ad_id']);
            } else {
                $this->model->updateTutorAd($adId, $tutorId);
                $_SESSION['selected_ad_id'] = $adId;
            }

            header("Location: /tutor-advertisement");
            exit;
        }
    }
}
