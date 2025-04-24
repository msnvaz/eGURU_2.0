<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="/css/tutor/events.css">
    <link rel="stylesheet" href="/css/tutor/random.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
    .container-events tbody tr:hover {
        background-color:rgb(242, 247, 251);
    }

    #entire {
            width: 900px;
    }

    #sessionModal {
    display: none;
    position: fixed;
    top: 20%;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    width: 400px;
    max-width: 90%;
    z-index: 1000;
}

#sessionModal h2 {
    color: #1e3a8a ;
    margin-top: 0;
    text-align: center;
    padding-bottom: 10px;
    border-bottom: 2px solid #e3f2fd;
    margin-bottom: 15px;
}

#sessionModal h3 {
    color: #1e3a8a;
    text-align: center;
    margin-top: 5px;
}

#modalPhoto {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid  #1e3a8a;
    display: block;
    margin: 0 auto 10px;
}

#sessionModal p {
    margin: 10px 0;
    line-height: 1.5;
}

#sessionModal strong {
    color: #333;
    width: 100px;
    display: inline-block;
}

#modalLink {
    display: inline-block;
    background-color: #E14177 ;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    margin-right: 10px;
}

#modalLink:hover {
    background-color: #e02362;
}

#closeModalBtn {
    background-color: #f5f5f5;
    color: #333;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

#closeModalBtn:hover {
    background-color: #e0e0e0;
}

.modal-actions {
    margin-top: 20px;
    text-align: center;
}
    </style>
</head>
<body>

<?php $page="event"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>

    <div id="entire">   
    
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
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($upcomingEvents as $event): ?>
                            <tr onclick='showSessionModal(<?= json_encode($event, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                <td><?= htmlspecialchars($event['subject_name']) ?></td>
                                <td><?= htmlspecialchars($event['student_grade']) ?></td>
                                <td><?= htmlspecialchars($event['student_first_name'] . ' ' . $event['student_last_name']) ?></td>
                                <td><?= date('d M Y', strtotime($event['scheduled_date'])) ?></td>
                                <td><?= date('h:i a', strtotime($event['schedule_time'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="previous-content" class="content">
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($previousEvents as $event): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($event['subject_name']); ?></td>
                                <td><?php echo htmlspecialchars($event['student_grade']); ?></td>
                                <td>
                                    <div>
                                        <a href="/tutor-student-profile/<?= $request['student_id'] ?>"><?php echo htmlspecialchars($event['student_first_name'] . ' ' . $event['student_last_name']); ?></a>
                                    </div>
                                </td>
                                <td><?php echo date('d M Y', strtotime($event['scheduled_date'])); ?></td>
                                <td><?php echo date('h:i a', strtotime($event['schedule_time'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
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

    <!-- Session Details Modal -->
<div id="sessionModal" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%); background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.3); width:350px; z-index:1000;">
    <h2>Session Details</h2>
    <img id="modalPhoto" src="" alt="Student Photo" style="width:60px; height:60px; border-radius:50%; margin-bottom:10px;">
    <div>
        <a id="modalStudentLink" href="#">
            <h3 id="modalStudent"></h3>
        </a>
    </div>

    <br>
    <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
    <p><strong>Grade:</strong> <span id="modalGrade"></span></p>
    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
    <p><strong>Date:</strong><span id="modalDate"></span></p>
    <p><strong>Time:</strong><span id="modalTime"></span></p>
    <p><strong>Meeting Link:</strong> <a href="#" id="modalLink" target="_blank">Join</a></p>
    <button id="closeModalBtn" onclick="document.getElementById('sessionModal').style.display='none';">Close</button>
</div>

<script>
function showSessionModal(event) {
    document.getElementById('modalPhoto').src = "/images/student-uploads/profilePhotos/" + event.student_profile_photo;
    document.getElementById('modalStudent').innerText = event.student_first_name + ' ' + event.student_last_name;
    document.getElementById('modalSubject').innerText = event.subject_name;
    document.getElementById('modalGrade').innerText = event.student_grade;
    document.getElementById('modalStatus').innerText = event.session_status;
    document.getElementById('modalDate').innerText = event.scheduled_date;
    document.getElementById('modalTime').innerText = event.schedule_time;
    document.getElementById('modalLink').href = event.meeting_link;
    document.getElementById('modalStudentLink').href = "/tutor-student-profile/" + event.student_id;

    document.getElementById('sessionModal').style.display = 'block';
}
</script>



</body>
</html>
