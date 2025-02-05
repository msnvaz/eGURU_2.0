<?php
include 'config\config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $nic = $_POST['nic'];
    $contactNumber = $_POST['contact_number'];

    try {
        $stmt = $pdo->prepare("INSERT INTO tutor_credentials (first_name, last_name, email, username, password, nic, contact_number) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$firstName, $lastName, $email, $username, $password, $nic, $contactNumber]);
        header("Location: signup.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
