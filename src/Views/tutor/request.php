<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Requests</title>
    <script src="request.js"></script>
    <link rel="stylesheet" href="/css/tutor/request.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php include '../src/Views/navbar.php'; ?>
<div class="sidebar">
            <h2>e-Guru</h2>
            <ul>
                <li><i class="fa-solid fa-table-columns"></i><a href="tutor-dashboard">Dashboard</a></li>
                <li><i class="fa-solid fa-calendar-days"></i><a href="tutor-event">Events</a></li>
                <li><i class="fa-solid fa-comment"></i><a href="tutor-request">Student Requests</a></li>
                <li><i class="fa-solid fa-user"></i><a href="tutor-public-profile">Public profile</a></li>
                <li><i class="fa-solid fa-star"></i><a href="tutor-feedback">Student Feeback</a></li>
                <li><i class="fa-solid fa-rectangle-ad"></i><a href="tutor-advertisement"> Advertisement</a></li>
                <li><i class="fa-solid fa-right-from-bracket"></i><a href="tutor-logout"> Logout</a></li>
            </ul>
        </div>
    <div id="body">
    <?php
       // include 'sidebar.php';
    ?>
    
        <div class="request_container">
        <div class="header">
            <div id="past-current-tab" class="active" onclick="toggleRequests('past-current')">Past & Current Student Requests</div>
            <div id="new-tab" onclick="toggleRequests('new')">New Student Requests</div>
        </div>
        <div id="past-current-requests" class="requests">
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>12 hours ago</div>
                <div><button class="accept">Accept</button></div>
            </div>
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>12 hours ago</div>
                <div><button class="accept">Accept</button></div>
            </div>
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>12 hours ago</div>
                <div><button class="accept">Accept</button></div>
            </div>
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>12 hours ago</div>
                <div><button class="accept">Accept</button></div>
            </div>
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>12 hours ago</div>
                <div><button class="accept">Accept</button></div>
            </div>
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>12 hours ago</div>
                <div><button class="accept">Accept</button></div>
            </div>
            <!-- Repeat similar blocks for more requests -->
        </div>
        <div id="new-requests" class="requests" style="display: none;">
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>12 hours to go</div>
                <div class="buttons">
                    <button class="accept">Accept</button>
                    <button class="decline">Decline</button>
                </div>
            </div>
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>5 hours to go</div>
                <div class="buttons">
                    <button class="accept">Accept</button>
                    <button class="decline">Decline</button>
                </div>
            </div>
            <div class="request">
                <div>Mathematics</div>
                <div>Grade 9</div>
                <div>John Doe</div>
                <div>3 hours to go</div>
                <div class="buttons">
                    <button class="accept">Accept</button>
                    <button class="decline">Decline</button>
                </div>
            </div>
            <!-- Repeat similar blocks for more requests -->
        </div>
    </div>
    <script src="script.js"></script>
    </div>
</body>
</html>
