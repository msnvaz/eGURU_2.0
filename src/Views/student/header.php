<!-- src/Views/navbar.php -->
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/student/header.css">
   

        
    <link rel="icon" type="image/png" href="/images/eGURU_3.png">
</head>
<div class="header">
    <a href="/" class="logo-link">
        <img src="./images/eGURU_3.png" alt="Your Logo" class="logo-image">
    </a>

    <div class="profile-container">
        <div class="notification">
            <i class="fas fa-bell"></i>
            <div class="notification-badge">1</div>
        </div>
    </div>
    <div class="logout">
        <a href="/student-logout" class="logout" onclick="logout()">Logout<i
                class="fa-solid fa-right-from-bracket"></i></a>
    </div>
</div>

</html>