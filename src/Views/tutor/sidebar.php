<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        .notification-badge {
            display: inline-block;
            background-color: #ff5869;
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

<?php
use App\Models\tutor\TutorInboxModel;

// Start session if not already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create model object
$tutorInboxModel = new TutorInboxModel();

// Get tutor ID from session
$tutorId = $_SESSION['tutor_id'] ?? null; // Adjust if you store it differently

if ($tutorId) {
    $unreadCount = $tutorInboxModel->getUnreadMessageCount($tutorId);
}
?>


<!-- Sidebar -->
<div class="sidebar" style="margin-top: 3%;">
            
            <ul>
                <li> <a class= "<?php echo ($page== "dashboard") ? 'active' : ''; ?>" href="/tutor-dashboard"> <i class="fa-solid fa-table-columns"></i>   <b style="font-weight: 500;"> Dashboard</b></a></li>
                <li> <a class= "<?php echo ($page== "event") ? 'active' : ''; ?>"href="/tutor-event"><i class="fa-solid fa-calendar-days"></i>    <b style="font-weight: 500;">Events</b></a></li>
                <li> <a class= "<?php echo ($page== "request") ? 'active' : ''; ?>"href="/tutor-request"><i class="fa-solid fa-comment"></i>    <b style="font-weight: 500;">Student Requests</b></a></li>
                <li> <a class= "<?php echo ($page== "feedback") ? 'active' : ''; ?>"href="/tutor-feedback"><i class="fa-solid fa-star"></i>     <b style="font-weight: 500;">Student Feedback</b></a></li>
                <li><a class= "<?php echo ($page== "profile") ? 'active' : ''; ?>"href="/tutor-public-profile"><i class="fa-solid fa-user"></i>     <b style="font-weight: 500;">Public Profile</b></a></li>
                <li> <a class= "<?php echo ($page== "cashout") ? 'active' : ''; ?>"href="index.php?action=cashout"><i class="fa-solid fa-money-bill"></i>    <b style="font-weight: 500;">Cashout</a></b></li>
                <li> <a class= "<?php echo ($page== "timeslot") ? 'active' : ''; ?>"href="/tutor-timeslot"><i class="fa fa-calendar-alt fa-2x"></i>    <b style="font-weight: 500;">Timeslots </b></a></li>
                <li> <a class= "<?php echo ($page== "advertisement") ? 'active' : ''; ?>"href="/tutor-advertisement"><i class="fa-solid fa-rectangle-ad"></i>     <b style="font-weight: 500;">Advertisement </b></a></li>
                <li><a class= "<?php echo ($page== "upload") ? 'active' : ''; ?>"href="/tutor-uploads"><i class="fa-solid fa-upload">     </i> <b style="font-weight: 500;">Study Materials</b></a></li>
                <li> <a class= "<?php echo ($page== "fee-request") ? 'active' : ''; ?>"href="/tutor-fee-request"><i class="fa-solid fa-comment"></i>    <b style="font-weight: 500;">Fee Requests</b></a></li>
                <li>
                    <a class="<?php echo ($page == "inbox") ? 'active' : ''; ?>" href="/tutor-inbox">
                        <i class="fa-solid fa-envelope"></i>  
                        <b style="font-weight: 500;">Tutor Inbox</b>
                        <span class="notification-badge"><?= htmlspecialchars($unreadCount) ?></span>
                    </a>
                </li>

                </ul>
            
        </div>
</body>
</html>
