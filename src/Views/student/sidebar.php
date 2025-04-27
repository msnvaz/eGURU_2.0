<?php

namespace App\Controllers\student;
use App\Models\student\StudentInboxModel;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Create model object
$studentInboxModel = new StudentInboxModel();

// Get tutor ID from session
$studentId = $_SESSION['student_id'] ?? null; // Adjust if you store it differently

if ($studentId) {
    $unreadCount = $studentInboxModel->getUnreadMessageCount($studentId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link rel="stylesheet" href="new.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">
<style>

.notification-badge {
    display: inline-block;
    background-color:#E14177;
    color: white;
    border-radius: 50%;
    padding: 4px 7px;
    font-size: 12px;
    font-weight: bold;
    line-height: 1;
    text-align: center;
    min-width: 20px;
    height: 20px;
}
</style>

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
                <li><a class= "<?php echo ($page== "inbox") ? 'active' : ''; ?>"href="student-inbox"><i class="fa-solid fa-envelope"></i> Inbox 
                        <span class="notification-badge"><?= htmlspecialchars($unreadCount) ?></span>
                    </a></li>
                <li><a class= "<?php echo ($page== "report") ? 'active' : ''; ?>"href="student-report"><i class="fa fa-exclamation-circle"></i></i> Report </a></li>
                </ul>
            
        </div>
</body>
</html>
       
                