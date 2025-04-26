<?php
use App\Controllers\student\StudentDashboardController;

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = "dashboard";
include __DIR__ . '/header.php';


// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: /student-login");
    exit();
}

// Initialize controller
$dashboardController = new StudentDashboardController();

// Fetch tutor replies
$tutorReplies = $dashboardController->getTutorReplies();

// Fetch upcoming and previous events
$upcomingEvents = $dashboardController->getUpcomingEvents();
$previousEvents = $dashboardController->getPreviousEvents();


// Fetch student details from session
$student_name = isset($_SESSION['student_name']) ? $_SESSION['student_name'] : 'Student';
$student_email = isset($_SESSION['student_email']) ? $_SESSION['student_email'] : 'Email';
$student_points = isset($_SESSION['student_points']) ? $_SESSION['student_points'] : 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/student/dashboard.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">

</head>


<body>
    
    <div class="container">
        <?php include 'sidebar.php'; ?>
        <div class="header-container">
            <div class="profile-section">
                <div class="welcome-text">
                    <h1>Welcome Back...! </h1>
                    <p>Keep up the good work!</p>
                </div>
                <div class="user-info">
                    <?php //var_dump($_SESSION['student_profile_photo']); ?>
                <img src="/images/student-uploads/profilePhotos/<?php echo $studentProfilePhoto; ?>" 
                    alt="Profile" class="user-avatar">
                    <div class="user-details">

                        <h2><?= isset($_SESSION['student_name']) ? htmlspecialchars($_SESSION['student_name']) : 'Student Name' ?>
                        </h2>
                        <p><?= isset($_SESSION['student_email']) ? htmlspecialchars($_SESSION['student_email']) : 'test@example.com' ?>
                        </p>
                        <p class="points">Points: <?= htmlspecialchars($student_points) ?></p> <!-- Updated -->
                        

                        <button class="find-tutor-btn">
    <a style="text-decoration:none; color:white;" href="/student-findtutor">Find Tutor</a>
</button>
                        <img src="images/student-uploads/welcome.png" alt="welcome" class="welcome_img">
                    </div>
                </div>
            </div>
            <div class="calendar-section">
                <div class="calendar-header">
                    <button class="calendar-nav" id="prevMonth">&lt;</button>
                    <h2 id="currentMonth"></h2>
                    <button class="calendar-nav" id="nextMonth">&gt;</button>
                </div>
                <div class="calendar-grid" id="calendarDays">
                    <div class="calendar-day-name">Sun</div>
                    <div class="calendar-day-name">Mon</div>
                    <div class="calendar-day-name">Tue</div>
                    <div class="calendar-day-name">Wed</div>
                    <div class="calendar-day-name">Thu</div>
                    <div class="calendar-day-name">Fri</div>
                    <div class="calendar-day-name">Sat</div>
                </div>
            </div>
        </div>

        <div class="content-container">
            <div class="events-section">
            <div class="section-header">
                    <h2>Upcoming Events</h2>
                    <a href="/student-events" class="view-all">View All</a>
                </div>
                <div class="event-list">
                    <?php foreach ($upcomingEvents as $event): ?>
                        <div class="event-card">
                            <div><?= htmlspecialchars($event['subject_name']) ?></div>
                            <div><?= htmlspecialchars($event['tutor_name']) ?></div>
                            <div><?= htmlspecialchars(date('d M Y', strtotime($event['scheduled_date']))) ?></div>
                            <div><?= htmlspecialchars(date('g:i A', strtotime($event['schedule_time']))) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div><br>
                <div class="section-header">
                    <h2>Previous Events</h2>
                    
                </div>
                <div class="event-list">
                    <?php foreach ($previousEvents as $event): ?>
                        <div class="event-card">
                            <div><?= htmlspecialchars($event['subject_name']) ?></div>
                            <div><?= htmlspecialchars($event['tutor_name']) ?></div>
                            <div><?= htmlspecialchars(date('d M Y', strtotime($event['scheduled_date']))) ?></div>
                            <div><?= htmlspecialchars(date('g:i A', strtotime($event['schedule_time']))) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

                </div>
          

        <div class="feedback-section">
                <div class="section-header">
                    <h2>Tutors' Feedback</h2>
                    <a href="student-feedback" class="view-all">View All</a>
                </div>
                <?php if (empty($tutorReplies)): ?>
                <div class="no-replies">
                    <p>No tutor replies yet.</p>
                </div>
            <?php else: ?>
                <?php foreach ($tutorReplies as $reply): ?>
                    <div class="tutor-reply-card">
                        <img src="/images/tutor_uploads/tutor_profile_photos/<?php echo htmlspecialchars($reply['tutor_profile_photo']); ?>" 
                             alt="Tutor" class="tutor-avatar">
                        <div class="tutor-reply-content">
                            <div class="tutor-name">
                                <?php echo htmlspecialchars($reply['tutor_first_name'] . ' ' . $reply['tutor_last_name']); ?>
                                <span class="tutor-level" style="background-color: <?php echo htmlspecialchars($reply['tutor_level_color']); ?>">
                                    <?php echo htmlspecialchars($reply['tutor_level']); ?>
                                </span>
                            </div>
                            <div class="tutor-subject">
                                <?php echo htmlspecialchars($reply['subject_name']); ?>
                            </div>
                            
                            <p class="reply-text">
                                "<?php echo htmlspecialchars($reply['tutor_reply']); ?>"
                            </p>
                
                            <div class="reply-date">
                                <?php echo $dashboardController->formatDateTime($reply['last_updated']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
                </div>
                
    <script src="js/student/dashboard.js"></script>
</body>

</html>