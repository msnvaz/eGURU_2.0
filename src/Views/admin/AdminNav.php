<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        @keyframes slideDown {
            from { 
                transform: translateX(-100%); 
                opacity: 0; }   
            to { transform: translateY(0);
                 opacity: 1; } } 
                 
                 
        .sidebar { 
            height: 100%; /* Full height */ 
            width: 15%; /* Sidebar width */ 
            position: fixed; /* Stay in place */ 
            top: 0; left: 0; 
            background-color: #B8E3E9; 
            overflow-x: hidden; /* Disable horizontal scroll */ 
            padding-top: 20px; 
            box-shadow : 3px 5px 10px rgba(0, 0, 0, 0.3); 
            transition: all 0.3s ease; 
            animation: slideDown 0.4s ease-out; /* Apply animation */ 
        }

        /* Sidebar links */
        .sidebar a {
            position: relative;
            padding: 5px 10px;
            padding-left: 20px;
            text-decoration: none;
            font-size: 15px;
            color: #293241;
            display: block;
            font-weight:600;
            margin:10px;
            border-radius:10px;  
        }

        /* Hover effect on links */
        .sidebar a:hover {
            /*background-color: #57575735;*/
            color: #ffffff;
            text-shadow: 3px 5px 10px rgba(53, 58, 85, 0.56);
        }   
        
        /* Heading for sidebar */
        .sidebar h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
        }

        i{
            margin-right: 5px;
        }

        hr{
            margin: 8px;
            border: 1px solid #29324166;
        }

        .current-page {
            color: white !important;
            background-color:rgba(41, 50, 65, 0.2);
            text-shadow: 3px 5px 10px rgba(53, 58, 85, 0.56);
        }

    </style>
</head>
<body>
<div class="sidebar">
   <h2></h2>
   <br><br>
   <a href="/admin-dashboard" data-path="/admin-dashboard">
       <i class="fa-solid fa-table-columns"></i>Dashboard
   </a>
   <hr>
   <a href="/admin-students" data-path="/admin-students">
       <i class="fa-solid fa-graduation-cap"></i>Students
   </a>
   <hr>
   <a href="/admin-tutors" data-path="/admin-tutors">
       <i class="fa-solid fa-chalkboard-user"></i>Tutors
   </a>
   <a href="/admin-tutor-requests" data-path="/admin-tutor-requests">
       <i class="fa-solid fa-bell"></i>Tutor Requests
   </a>
   <a href="/admin-tutor-grading" data-path="/admin-tutor-grading">
       <i class="fa-solid fa-stairs"></i>Tutor Grading
   </a>
   <a href="/admin-tutor-upgrade-requests" data-path="/admin-tutor-upgrade-requests">
       <i class="fa-solid fa-money-bill-1"></i>Fee Requests
   </a>
   <hr>
   <div class="active">
       <a href="/admin-inbox" data-path="/admin-inbox">
           <i class="fa-solid fa-envelope"></i>Inbox
       </a>
   </div>
   <a href="/admin-subjects" data-path="/admin-subjects">
       <i class="fa-solid fa-book"></i>Subjects
   </a>
   <a href="/admin-announcement" data-path="/admin-announcement">
       <i class="fa-solid fa-bullhorn"></i>Announcement
   </a>
   <a href="/admin-sessions" data-path="/admin-sessions">
       <i class="fa-solid fa-calendar-days"></i>Sessions
   </a>
    <!--transactions-->
    <a href="/admin-points" data-path="/admin-points">
        <i class="fa-solid fa-credit-card"></i>Points
    </a>
    <a href="/admin-transactions" data-path="/admin-transactions">
        <i class="fa-solid fa-hand-holding-dollar"></i>Session Payments
    </a>
    <hr>
    <a href="/admin-settings" data-path="/admin-settings">
        <i class="fa-solid fa-gear"></i>Settings
    </a>
</div>

<script>
    // Get the current path from the URL
    const currentPath = window.location.pathname;
    
    // Find all sidebar links
    const sidebarLinks = document.querySelectorAll('.sidebar a');
    
    // Loop through each link and check if its data-path matches the current path
    sidebarLinks.forEach(link => {
        const linkPath = link.getAttribute('data-path');
        if (linkPath === currentPath) {
            link.classList.add('current-page');
        }
    });
</script>
</body>
</html>