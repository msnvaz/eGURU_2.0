<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout </title>
    <link rel="stylesheet" href="css/student/new.css">
    
</head>
<?php $page="logout"; ?>
<body>
<?php include '../src/Views/navbar.php'; ?>
<div class="container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
<div class="logout-container">
    <h2>Are you sure you want to log out?</h2>
    <button class="logout-btn" onclick="logout()">Logout</button>
</div>
</div>

<script src="js/student/logout.js"></script>

</body>
</html>
