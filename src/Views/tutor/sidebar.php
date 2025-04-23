<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">


</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
            <h2></h2>
            <ul>
                <li> <a class= "<?php echo ($page== "dashboard") ? 'active' : ''; ?>" href="/tutor-dashboard"> <i class="fa-solid fa-table-columns"></i>   <b> Dashboard</b></a></li>
                <li> <a class= "<?php echo ($page== "event") ? 'active' : ''; ?>"href="/tutor-event"><i class="fa-solid fa-calendar-days"></i>    <b>Events</b></a></li>
                <li> <a class= "<?php echo ($page== "request") ? 'active' : ''; ?>"href="/tutor-request"><i class="fa-solid fa-comment"></i>    <b>Student Requests</b></a></li>
                <li> <a class= "<?php echo ($page== "feedback") ? 'active' : ''; ?>"href="/tutor-feedback"><i class="fa-solid fa-star"></i>     <b>Student Feedback</b></a></li>
                <li><a class= "<?php echo ($page== "profile") ? 'active' : ''; ?>"href="/tutor-public-profile"><i class="fa-solid fa-user"></i>     <b>Public Profile</b></a></li>
                <li> <a class= "<?php echo ($page== "advertisement") ? 'active' : ''; ?>"href="/tutor-advertisement"><i class="fa-solid fa-rectangle-ad"></i>     <b>Advertisement </b></a></li>
                <li> <a class= "<?php echo ($page== "payment") ? 'active' : ''; ?>"href="/tutor-payment"><i class="fa-solid fa-money-bill"></i>    <b>Payments</a></b></li>
                <li> <a class= "<?php echo ($page== "timeslot") ? 'active' : ''; ?>"href="/tutor-timeslot"><i class="fa fa-calendar-alt fa-2x"></i>    <b>Timeslots </b></a></li>
                <li><a class= "<?php echo ($page== "upload") ? 'active' : ''; ?>"href="/tutor-uploads"><i class="fa-solid fa-upload">     </i> <b>Study Materials</b></a></li>
                <li> <a class= "<?php echo ($page== "fee-request") ? 'active' : ''; ?>"href="/tutor-fee-request"><i class="fa-solid fa-comment"></i>    <b>Tutor Fee Requests</b></a></li>

                </ul>
            
        </div>
</body>
</html>
