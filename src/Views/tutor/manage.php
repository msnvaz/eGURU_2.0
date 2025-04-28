<?php

session_start();

$uploadDir = 'assets/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'replace' && isset($_POST['currentName']) && isset($_FILES['newFile'])) {
        $currentName = $uploadDir . basename($_POST['currentName']);
        $newFile = $_FILES['newFile'];

        
        if (file_exists($currentName)) {
            
            unlink($currentName); // Delete the current file
            if (move_uploaded_file($newFile['tmp_name'], $currentName)) {
                $_SESSION['message'] = 'File replaced successfully!';
            } else {
                $_SESSION['message'] = 'Failed to replace the file.';
            }
        } else {
            $_SESSION['message'] = 'Original file does not exist.';
        }

        
        header("Location: update_init.php");
        exit;
    }

    if ($action === 'delete' && isset($_POST['fileName'])) {
        $fileName = $uploadDir . basename($_POST['fileName']);

        if (file_exists($fileName)) {
            if (unlink($fileName)) {
                $_SESSION['message'] = 'File deleted successfully!';
            } else {
                $_SESSION['message'] = 'Failed to delete the file.';
            }
        } else {
            $_SESSION['message'] = 'File does not exist.';
        }

        
        header("Location: update_init.php");
        exit;
    }
}

?>
