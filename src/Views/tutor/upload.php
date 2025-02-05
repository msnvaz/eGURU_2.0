<?php
$uploadDir = 'assets/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $targetFile = $uploadDir . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        echo "<script>
            alert('File uploaded successfully!');
            window.location.href = 'manage_files.html';
        </script>";
    } else {
        echo "<script>
            alert('Failed to upload file. Please try again.');
            window.location.href = 'manage_files.html';
        </script>";
    }
}
?>
