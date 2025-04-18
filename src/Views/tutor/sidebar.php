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
                <li> <a class= "<?php echo ($page== "dashboard") ? 'active' : ''; ?>" href="tutor-dashboard"> <i class="fa-solid fa-table-columns"></i>    Dashboard</a></li>
                <li> <a class= "<?php echo ($page== "event") ? 'active' : ''; ?>"href="tutor-event"><i class="fa-solid fa-calendar-days"></i>    Events</a></li>
                <li> <a class= "<?php echo ($page== "request") ? 'active' : ''; ?>"href="tutor-request"><i class="fa-solid fa-comment"></i>    Student Requests</a></li>
                <li> <a class= "<?php echo ($page== "feedback") ? 'active' : ''; ?>"href="tutor-feedback"><i class="fa-solid fa-star"></i>     Student Feedback</a></li>
                <li><a class= "<?php echo ($page== "profile") ? 'active' : ''; ?>"href="tutor-public-profile"><i class="fa-solid fa-user"></i>     Public Profile</a></li>
                <li> <a class= "<?php echo ($page== "advertisement") ? 'active' : ''; ?>"href="tutor-advertisement"><i class="fa-solid fa-rectangle-ad"></i>     Advertisement </a></li>
                <li> <a class= "<?php echo ($page== "payment") ? 'active' : ''; ?>"href=""><i class="fa-solid fa-money-bill"></i>    Payments</a></li>
                <li> <a class= "<?php echo ($page== "timeslot") ? 'active' : ''; ?>"href="tutor-timeslot"><i class="fa fa-calendar-alt fa-2x"></i>    Timeslots </a></li>
                <li><a class= "<?php echo ($page== "upload") ? 'active' : ''; ?>"href="tutor-uploads"><i class="fa-solid fa-upload">     </i> Uploads </a></li>
                <li> <a class= "<?php echo ($page== "fee-request") ? 'active' : ''; ?>"href="tutor-fee-request"><i class="fa-solid fa-comment"></i>    Tutor Fee Requests</a></li>

                </ul>
            
        </div>
</body>
</html>
