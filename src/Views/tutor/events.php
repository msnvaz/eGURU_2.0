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

       
        .day.upcoming-event {
            background-color: rgba(202, 41, 95, 0.30);
            border-radius: 5px;
            cursor: pointer;
        }

        .day.previous-event {
            background-color: rgba(26, 53, 128, 0.30);
            border-radius: 5px;
            cursor: pointer;
        }

      
        tr.highlight {
            background-color: #e1f5fe !important;
            animation: highlight-pulse 2s ease-in-out;
        }

        @keyframes highlight-pulse {
            0% { background-color: #e1f5fe; }
            50% { background-color: #b3e5fc; }
            100% { background-color: #e1f5fe; }
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
            color: #1e3a8a;
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
            border: 3px solid #1e3a8a;
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
            background-color: #E14177;
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
            /* General Modal Style */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 150px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background: rgba(0, 0, 0, 0.6);
        }

        .modal-content {
            background: #fff;
            margin: auto;
            padding: 30px 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-actions {
            margin-top: 20px;
        }

        .confirm-btn, .cancel-btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .confirm-btn {
            background-color: #28a745;
            color: white;
        }

        .confirm-btn:hover {
            background-color: #218838;
        }

        .cancel-btn {
            background-color: #dc3545;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #c82333;
        }

        /* Cancel Button inside table */
        .cancel-button {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }

        
        .modal {
            display: none; 
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.59); 
        }

       
        .modal-content {
            border-top: 6px solid #e03570;
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
            align-items: center;
        }

      
        .close {
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 24px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        
        .modal-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .confirm-button {
            background-color: #ff4081;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-button:hover {
            background-color: #e03570;
        }

        .modal-cancel-button {
            background-color: #ddd;
            color: #333;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-cancel-button:hover {
            background-color: #bbb;
        }
    </style>
</head>
<body>

<?php $page="event"; ?>


<?php include 'sidebar.php'; ?>


<?php include '../src/Views/tutor/header.php'; ?>

<?php
$successMessage = isset($_GET['success']) && !empty($_GET['success']) ? $_GET['success'] : null;
$errorMessage = isset($_GET['error']) && !empty($_GET['error']) ? $_GET['error'] : null;
?>

<?php if ($successMessage || $errorMessage): ?>
    <div id="messageModal" class="modal" style="display: block;">
        <div class="modal-content">
            <span class="close" onclick="closeMessageModal()">&times;</span>
            <h2><?= $successMessage ? 'Success' : 'Error' ?></h2>
            <hr style="color:#adb5bd;">
            <br>
            <p style="text-align:center; color: <?= $successMessage ? 'black' : 'red' ?>;">
                <?= htmlspecialchars($successMessage ?? $errorMessage) ?>
            </p>
            <div class="modal-actions" >
                <button style="margin-left:43%;" class="confirm-button" onclick="closeMessageModal()">OK</button>
            </div>
        </div>
    </div>
<?php endif; ?>


<script>
    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
        const url = new URL(window.location);
        url.searchParams.delete('success');
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url);
    }
</script>



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
                <div id="upcoming-tab" class="active" onclick="showUpcoming()">Upcoming Events</div>
                <div id="previous-tab" onclick="showPrevious()">Previous Events</div>
            </div>
    
            <div id="upcoming-events" class="content active">
                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Student</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($upcomingEvents as $event): ?>
                            <?php 
                                $selectedDate = isset($_GET['date']) ? $_GET['date'] : null;
                                $isHighlighted = ($selectedDate === $event['scheduled_date']);
                            ?>
                            <tr class="event-row <?php echo $isHighlighted ? 'highlight' : ''; ?>" onclick='showSessionModal(<?= json_encode($event, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
                                <td><?= htmlspecialchars($event['subject_name']) ?></td>
                                <td><?= htmlspecialchars($event['student_grade'] ?? 'Null') ?></td>
                                <td><?= htmlspecialchars(($event['student_first_name'] ?? '') . ' ' . ($event['student_last_name'] ?? '')) ?></td>
                                <td><?= date('d M Y', strtotime($event['scheduled_date'] ?? '')) ?></td>
                                <td><?= date('h:i a', strtotime($event['schedule_time'] ?? '')) ?></td>
                                <td>
                                    <button class="cancel-button" type="button" onclick="openCancelModal(<?= $event['session_id'] ?>); event.stopPropagation();">Cancel</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            
            <div id="cancelModal" class="modal">
                <div class="modal-content">
                    <p>Are you sure you want to cancel this session?</p>
                    <div class="modal-actions">
                        <button class="confirm-btn" onclick="confirmCancel()">Yes</button>
                        <button class="cancel-btn" onclick="closeCancelModal()">No</button>
                    </div>
                </div>
            </div>



            <script>
            let sessionIdToCancel = null;

            function openCancelModal(sessionId) {
                sessionIdToCancel = sessionId;
                document.getElementById('cancelModal').style.display = 'block';
            }

            function closeCancelModal() {
                sessionIdToCancel = null;
                document.getElementById('cancelModal').style.display = 'none';
            }

            function confirmCancel() {
                if (sessionIdToCancel) {
                    window.location.href = `/tutor-session-cancel/${sessionIdToCancel}`;
                }
            }



            </script>


            <div id="previous-events" class="content">
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
                            <?php 
                                
                                $selectedDate = isset($_GET['date']) ? $_GET['date'] : null;
                                $isHighlighted = ($selectedDate === $event['scheduled_date']);
                            ?>
                            <tr class="event-row <?php echo $isHighlighted ? 'highlight' : ''; ?>" >
                                <td><?php echo htmlspecialchars($event['subject_name']); ?></td>
                                <td><?php echo htmlspecialchars($event['student_grade']?? 'Null'); ?></td>
                                <td>
                                    <?php $studentId = $event['student_id'] ?? '';
                                    $studentName = trim(($event['student_first_name'] ?? '') . ' ' . ($event['student_last_name'] ?? ''));
                                    ?>
                                    <div>
                                        <a href="/tutor-student-profile/<?= htmlspecialchars($studentId) ?>">
                                            <?= htmlspecialchars($studentName) ?>
                                        </a>
                                    </div>
                                </td>
                                <td><?php echo date('d M Y', strtotime($event['scheduled_date'] ?? 'Not Scheduled')); ?></td>
                                <td><?php echo date('h:i a', strtotime($event['schedule_time'] ?? 'Not Scheduled')); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    
    
    <div id="sessionModal" style="display:none; position:fixed; top:20%; left:50%; transform:translateX(-50%); background:white; padding:20px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.3); width:350px; z-index:1000;">
        <h2>Session Details</h2>
        <img id="modalPhoto" src="" alt="Student Photo" style="width:60px; height:60px; border-radius:50%; margin-bottom:10px;">
        <div>
            <a id="modalStudentLink" href="#">
                <h3 id="modalStudent"></h3>
            </a>
        </div>

        <br>
        <p><strong>Session ID:</strong> <span id="modalSession"></span></p>
        <p><strong>Subject:</strong> <span id="modalSubject"></span></p>
        <p><strong>Grade:</strong> <span id="modalGrade"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
        <p><strong>Date:</strong><span id="modalDate"></span></p>
        <p><strong>Time:</strong><span id="modalTime"></span></p>
        <p><strong>Meeting Link:</strong> <a href="#" id="modalLink" target="_blank">Join</a></p>
        <button id="closeModalBtn" onclick="document.getElementById('sessionModal').style.display='none';">Close</button>
    </div>

    <script src="/js/tutor/eventcal.js"></script>
    <script>
        function showUpcoming() {
            document.getElementById('upcoming-events').style.display = 'block';
            document.getElementById('previous-events').style.display = 'none';
            document.getElementById('upcoming-tab').classList.add('active');
            document.getElementById('previous-tab').classList.remove('active');
        }

        function showPrevious() {
            document.getElementById('upcoming-events').style.display = 'none';
            document.getElementById('previous-events').style.display = 'block';
            document.getElementById('upcoming-tab').classList.remove('active');
            document.getElementById('previous-tab').classList.add('active');
        }

        function showSessionModal(event) {
            document.getElementById('modalPhoto').src = "/images/student-uploads/profilePhotos/" + event.student_profile_photo;
            document.getElementById('modalSession').innerText = event.session_id;
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

        window.onclick = function(event) {
            const modal = document.getElementById('sessionModal');
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>