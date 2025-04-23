<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="new.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">


</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
            <h2></h2>
            <ul>
                <li> <a class= "<?php echo ($page== "dashboard") ? 'active' : ''; ?>" href="student-dashboard"> <i class="fa-solid fa-table-columns"></i>Dashboard</a></li>
                <li> <a class= "<?php echo ($page== "event") ? 'active' : ''; ?>"href="student-events"><i class="fa-solid fa-calendar-days"></i>Events</a></li>
                <li> <a class= "<?php echo ($page== "feedback") ? 'active' : ''; ?>"href="student-feedback"><i class="fa-solid fa-comment"></i>Feedback</a></li>
                <li><a class= "<?php echo ($page== "profile") ? 'active' : ''; ?>"href="student-publicprofile"><i class="fa-solid fa-user"></i> Public Profile</a></li>
                <li> <a class= "<?php echo ($page== "session") ? 'active' : ''; ?>"href="student-session"><i class="fa fa-calendar-alt fa-2x"></i>Requests </a></li>
                <li> <a class= "<?php echo ($page== "payment") ? 'active' : ''; ?>"href="student-payment"><i class="fa-solid fa-money-bill"></i>Payments</a></li>
                <li> <a class= "<?php echo ($page== "timeslot") ? 'active' : ''; ?>"href="student-timeslot"><i class="fa fa-calendar-alt fa-2x"></i>Timeslots </a></li>
                <li><a class= "<?php echo ($page== "download") ? 'active' : ''; ?>"href="student-downloads"><i class="fa-solid fa-download"></i> Downloads </a></li>
                <li><a class= "<?php echo ($page== "report") ? 'active' : ''; ?>"href="student-report"><i class="fa fa-exclamation-circle"></i></i> Report </a></li>
                </ul>
            
        </div>
</body>
</html>
       
                