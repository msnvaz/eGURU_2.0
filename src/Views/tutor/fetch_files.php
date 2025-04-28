<?php
session_start();
include 'config\config.php  '; 

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php?action=login");
    exit();
}

$tutor_id = $_SESSION['tutor_id'];
$conn = openConnection();
$stmt = $conn->prepare("SELECT name, visibility, file_path FROM study_materials WHERE tutor_id = ?");
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$result = $stmt->get_result();

$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($files);
?>
