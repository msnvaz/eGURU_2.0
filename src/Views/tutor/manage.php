<?php
// Start the session to manage feedback messages
session_start();

$uploadDir = 'assets/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'replace' && isset($_POST['currentName']) && isset($_FILES['newFile'])) {
        $currentName = $uploadDir . basename($_POST['currentName']);
        $newFile = $_FILES['newFile'];

        // Ensure the current file exists before replacing
        if (file_exists($currentName)) {
            // Replace the file by deleting the old one and saving the new one
            unlink($currentName); // Delete the current file
            if (move_uploaded_file($newFile['tmp_name'], $currentName)) {
                $_SESSION['message'] = 'File replaced successfully!';
            } else {
                $_SESSION['message'] = 'Failed to replace the file.';
            }
        } else {
            $_SESSION['message'] = 'Original file does not exist.';
        }

        // Redirect back to the same interface
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

        // Redirect back to the same interface
        header("Location: update_init.php");
        exit;
    }
}

?>
