<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="/css/tutor/events.css">
    <link rel="stylesheet" href="/css/tutor/random.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../src/Views/navbar.php'; ?>
    <?php //include 'sidebar.php'; ?>
    <div id="entire">   
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
        <div class="calendars-events">
            <div class="calendar-events" id="prev-month-calendar">
                <div class="calendar-events-header">
                    <div id="prev-month-year"></div>
                </div>
                <div class="calendar-events-body">
                    <div class="day-names">
                        <span>Sun</span>
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                    </div>
                    <div id="prev-days" class="days"></div>
                </div>
            </div>
            <div class="calendar-events" id="current-month-calendar">
                <div class="calendar-events-header">
                    <button id="prev" class="nav-button">&lt;</button>
                    <div id="current-month-year"></div>
                    <button id="next" class="nav-button">&gt;</button>
                </div>
                <div class="calendar-body">
                    <div class="day-names">
                        <span>Sun</span>
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                    </div>
                    <div id="current-days" class="days"></div>
                </div>
            </div>
            <div class="calendar-events" id="next-month-calendar">
                <div class="calendar-events-header">
                    <div id="next-month-year"></div>
                </div>
                <div class="calendar-body">
                    <div class="day-names">
                        <span>Sun</span>
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                    </div>
                    <div id="next-days" class="days"></div>
                </div>
            </div>
        </div>

        <div class="container-events">
            <div class="tabs">
                <div id="upcoming-tab" class="active" onclick="toggleContent('upcoming')">Upcoming Events</div>
                <div id="previous-tab" onclick="toggleContent('previous')">Previous Events</div>
            </div>
            <div id="upcoming-content" class="content active">
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Instructor</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mathematics</td>
                            <td>Grade 9</td>
                            <td>John Doe</td>
                            <td>20 Aug 2024</td>
                            <td>2:00 pm</td>
                        </tr>
                        <tr>
                            <td>Science</td>
                            <td>Grade 9</td>
                            <td>John Doe</td>
                            <td>20 Aug 2024</td>
                            <td>2:00 pm</td>
                        </tr>
                        <tr>
                            <td>English</td>
                            <td>Grade 9</td>
                            <td>John Doe</td>
                            <td>20 Aug 2024</td>
                            <td>2:00 pm</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="previous-content" class="content">
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Instructor</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>History</td>
                            <td>Grade 9</td>
                            <td>Jane Smith</td>
                            <td>15 Jul 2024</td>
                            <td>10:00 am</td>
                        </tr>
                        <tr>
                            <td>Geography</td>
                            <td>Grade 9</td>
                            <td>Jane Smith</td>
                            <td>15 Jul 2024</td>
                            <td>11:00 am</td>
                        </tr>
                        <tr>
                            <td>Biology</td>
                            <td>Grade 9</td>
                            <td>Jane Smith</td>
                            <td>15 Jul 2024</td>
                            <td>12:00 pm</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="/js/tutor/eventcal.js"></script>
    <script>
        function toggleContent(contentType) {
            const upcomingTab = document.getElementById('upcoming-tab');
            const previousTab = document.getElementById('previous-tab');
            const upcomingContent = document.getElementById('upcoming-content');
            const previousContent = document.getElementById('previous-content');

            if (contentType === 'upcoming') {
                upcomingTab.classList.add('active');
                previousTab.classList.remove('active');
                upcomingContent.classList.add('active');
                previousContent.classList.remove('active');
            } else {
                previousTab.classList.add('active');
                upcomingTab.classList.remove('active');
                previousContent.classList.add('active');
                upcomingContent.classList.remove('active');
            }
        }
    </script>
</body>
</html>
