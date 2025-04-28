<?php

namespace App\Controllers\tutor;

use App\Models\tutor\AdvertisementModel;

class TutorAdvertisementController {
    private $model;

    public function __construct() {
        $this->model = new AdvertisementModel();
    }

    
    public function showAdvertisementGalleryPage() {


        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
    
        $tutorData = null;
    
        $ads = [];
        
    
        
        if (isset($_SESSION['tutor_id'])) {
            $tutorId = $_SESSION['tutor_id'];

            
            $ads = $this->model->getAllAdvertisements($tutorId);

        }

      
        require_once __DIR__ . '/../../Views/tutor/advertisement_gallery.php';
    }

    
    public function uploadAdvertisement() {

        

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
    }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image']) && isset($_POST['description'])) {
                
                $uploadDir = './uploads/tutor_ads/';
                $file_name = basename($_FILES['image']['name']);
                $uploadPath = $uploadDir . $file_name;

                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                   
                    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

                    
                    if (isset($_SESSION['tutor_id'])) {
                        $tutorId = $_SESSION['tutor_id'];
            
                        $this->model->addAdvertisement($file_name, $description, $tutorId);
                    }
                    
                   
                    header('Location: /tutor-advertisement?success=Upload Successful');
                    exit();
                } else {
                    echo "Failed to upload the image. Please try again.";
                }
            } else {
                echo "Please fill all fields and select an image.";
            }
        } else {
            
            require_once __DIR__ . '/../../views/tutor/upload_advertisement.php?error=Upload Failed';
        }
    }

    public function deleteAdvertisement()
    {
        if (isset($_POST['id'])) {
            $model = new AdvertisementModel();
            $model->deleteAdvertisementById($_POST['id']);
            header("Location: /tutor-advertisement?success=Delete Successful"); // Redirect back to gallery
        }
    }

    public function updateAdvertisement()
    {
        if (isset($_POST['id']) && isset($_POST['description'])) {
            $model = new AdvertisementModel();
            $model->updateAdvertisementDescription($_POST['id'], $_POST['description']);
            header("Location: /tutor-advertisement?success=Update Successful"); // Redirect back to gallery
        }
    }

    public function selectAd() {
       

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: /tutor-login");
        exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adId = $_POST['ad_id'];
            $tutorId = $_SESSION['tutor_id'];

            
            if ($_SESSION['selected_ad_id'] == $adId) {
                $this->model->updateTutorAd(null, $tutorId);
                unset($_SESSION['selected_ad_id']);
            } else {
                $this->model->updateTutorAd($adId, $tutorId);
                $_SESSION['selected_ad_id'] = $adId;
            }

            header("Location: /tutor-advertisement?success=Change Successful");
            exit;
        }
    }

    public function updateTutorAdvertisement() {
        if (isset($_POST['id']) && isset($_POST['description']) && isset($_POST['tutor_id'])) {
            $tutorId = $_POST['tutor_id'];
            $adId = $_POST['id'];
            $description = $_POST['description'];
            
            $advertisementModel = new \App\Models\tutor\AdvertisementModel();
            $advertisementModel->updateAdvertisementDescription($adId, $description);
            
            header("Location: /admin-tutor-profile/{$tutorId}?success=Advertisement updated successfully");
            exit();
        }
    }
    
    public function deleteTutorAdvertisement() {
        if (isset($_POST['id']) && isset($_POST['tutor_id'])) {
            $tutorId = $_POST['tutor_id'];
            $adId = $_POST['id'];
            
            $advertisementModel = new \App\Models\tutor\AdvertisementModel();
            $advertisementModel->deleteAdvertisementById($adId);
            
            header("Location: /admin-tutor-profile/{$tutorId}?success=Advertisement deleted successfully");
            exit();
        }
    }
    
    public function selectTutorAdvertisement() {
        if (isset($_POST['ad_id']) && isset($_POST['tutor_id'])) {
            $tutorId = $_POST['tutor_id'];
            $adId = $_POST['ad_id'];
            
            $advertisementModel = new \App\Models\tutor\AdvertisementModel();
            $advertisementModel->updateTutorAd($adId, $tutorId);
            
            header("Location: /admin-tutor-profile/{$tutorId}?success=Advertisement selected successfully");
            exit();
        }
    }
}
