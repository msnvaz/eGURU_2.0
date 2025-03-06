<?php
use App\Controllers\student\StudentDashboardController;
// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: /student-login");
    exit();
}

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
<?php $page="dashboard"; ?>
<body>
<?php include '../src/Views/student/header.php'; ?>
    <div class="container">
    <?php include 'sidebar.php'; ?>
        <div class="header-container">
            <div class="profile-section">
                <div class="welcome-text">
                <h1>Welcome <?= htmlspecialchars(explode(' ', $student_name)[0]) ?>👋</h1>
                <p>Keep up the good work!</p>
                </div>
                <div class="user-info">
                <img src="images/student-uploads/profilePhotos/<?php echo isset($_SESSION['profile_picture']) ? $_SESSION['profile_picture'] : 'profile1.jpg'; ?>"
                        alt="Profile" class="user-avatar">
                    <div class="user-details">

                        <h2><?= isset($_SESSION['student_name']) ? htmlspecialchars($_SESSION['student_name']) : 'Student Name' ?>
                        </h2>
                        <p><?= isset($_SESSION['student_email']) ? htmlspecialchars($_SESSION['student_email']) : 'test@example.com' ?>
                        </p>
                        <p class="points">Points:
                            <?= isset($_SESSION['student_points']) ? htmlspecialchars($_SESSION['student_points']) : '0' ?>
                        </p>

                        <button class="find-tutor-btn"><a style="text-decoration:none; color:white;"
                                href="student-findtutor">Find Tutor</a></button>
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
                    <a href="student-events" class="view-all">View All</a>
                </div>
                <div class="event-list">
                    <div class="event-card">
                        <div>Mathematics</div>
                        <div>Mr. Kavinda</div>
                        <div>20 Dec 2024</div>
                        <div>2:00 PM</div>
                    </div>
                    <div class="event-card">
                        <div>Science</div>
                        <div>Mr. Dulanjaya</div>
                        <div>21 Dec 2024</div>
                        <div>10:00 AM</div>
                    </div>
                    
                </div><br>
                <div class="section-header">
                    <h2>Previous Events</h2>
                    <a href="student-events" class="view-all">View All</a>
                </div>
                <div class="event-list">
                    <div class="event-card">
                        <div>History</div>
                        <div>Mr. Nuwan</div>
                        <div>20 Nov 2024</div>
                        <div>4:00 PM</div>
                    </div>
                    <div class="event-card">
                        <div>ICT</div>
                        <div>Ms. Chathuri</div>
                        <div>29 Nov 2024</div>
                        <div>9:00 AM</div>
                    </div>
                    
                </div>
            </div>

            <div class="feedback-section">
                <div class="section-header">
                    <h2>Tutors' Feedback</h2>
                    <a href="student-feedback" class="view-all">View All</a>
                </div>
                <div class="feedback-list">
                    <div class="feedback-item">
                        <img src="images/student-uploads/tutor1.jpg" alt="Tutor" class="feedback-avatar">
                        <div class="feedback-content">
                            <p class="feedback-text">"Good effort! Pay more attention to details."</p>
                            <p class="feedback-date">15 Aug 2024 - 4:50 PM</p>
                        </div>
                    </div>
                    <div class="feedback-item">
                        <img src="images/student-uploads/tutor7.jpg" alt="Tutor" class="feedback-avatar">
                        <div class="feedback-content">
                            <p class="feedback-text">"Good progress, focus on improving presentation."</p>
                            <p class="feedback-date">15 Aug 2024 - 3:20 PM</p>
                        </div>
                    </div>
                    <div class="feedback-item">
                        <img src="images/student-uploads/tutor2.jpg" alt="Tutor" class="feedback-avatar">
                        <div class="feedback-content">
                            <p class="feedback-text">"Excellent participation, keep it up!"</p>
                            <p class="feedback-date">15 Aug 2024 - 3:10 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        class Calendar {
            constructor() {
                this.currentDate = new Date();
                this.selectedDate = null;
                
                this.monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];

                this.init();
            }

            init() {
                this.updateMonthDisplay();
                this.renderCalendar();

                document.getElementById('prevMonth').addEventListener('click', () => {
                    this.currentDate.setMonth(this.currentDate.getMonth() - 1);
                    this.updateMonthDisplay();
                    this.renderCalendar();
                });

                document.getElementById('nextMonth').addEventListener('click', () => {
                    this.currentDate.setMonth(this.currentDate.getMonth() + 1);
                    this.updateMonthDisplay();
                    this.renderCalendar();
                });
            }

            updateMonthDisplay() {
                const monthYear = `${this.monthNames[this.currentDate.getMonth()]} ${this.currentDate.getFullYear()}`;
                document.getElementById('currentMonth').textContent = monthYear;
            }

            renderCalendar() {
                const calendarDays = document.getElementById('calendarDays');
                const firstDay = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1);
                const lastDay = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0);
                
                // Clear existing calendar days except day names
                while (calendarDays.children.length > 7) {
                    calendarDays.removeChild(calendarDays.lastChild);
                }

                // Add empty cells for days before the first day of the month
                for (let i = 0; i < firstDay.getDay(); i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'calendar-day';
                    calendarDays.appendChild(emptyDay);
                }

                // Add days of the month
                for (let day = 1; day <= lastDay.getDate(); day++) {
                    const dayElement = document.createElement('div');
                    dayElement.className = 'calendar-day';
                    dayElement.textContent = day;

                    // Check if this is today's date
                    const today = new Date();
                    if (day === today.getDate() &&
                        this.currentDate.getMonth() === today.getMonth() &&
                        this.currentDate.getFullYear() === today.getFullYear()) {
                        dayElement.classList.add('selected');
                    }

                    dayElement.addEventListener('click', () => {
                        document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('selected'));
                        dayElement.classList.add('selected');
                        this.selectedDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), day);
                    });

                    calendarDays.appendChild(dayElement);
                }
            }
        }

        // Initialize calendar when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            new Calendar();
        });
    </script>
</body>
</html>