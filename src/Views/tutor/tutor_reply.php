<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Feedback Dashboard</title>
    <link rel="stylesheet" href="/css/tutor/tutor_reply.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
<div class="sidebar">
            <h2>e-Guru</h2>
            <ul>
                <li><i class="fa-solid fa-table-columns"></i><a href="tutor-dashboard">Dashboard</a></li>
                <li><i class="fa-solid fa-calendar-days"></i><a href="tutor-event">Events</a></li>
                <li><i class="fa-solid fa-comment"></i><a href="tutor-request">Student Requests</a></li>
                <li><i class="fa-solid fa-user"></i><a href="tutor-public-profile">Public profile</a></li>
                <li><i class="fa-solid fa-star"></i><a href="tutor-feedback">Student Feedback</a></li>
                <li><i class="fa-solid fa-rectangle-ad"></i><a href="tutor-advertisement"> Advertisement</a></li>
                <li><i class="fa-solid fa-right-from-bracket"></i><a href="tutor-logout"> Logout</a></li>
            </ul>
        </div>
<?php include '../src/Views/navbar.php'; ?>
    <?php
        //include 'sidebar.php'
    ?>
    <div class="dashboard-feedback">
        <h1 class="feedback-h1">Student Feedback Dashboard</h1>
        <div id="feedbackList">
        <script src="js/tutor/tutor_reply.js"></script>

        </div>
    </div>

    
    
</body>
</html>