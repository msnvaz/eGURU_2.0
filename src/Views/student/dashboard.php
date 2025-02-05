<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: #f5f7fb;
            color: #1a1a1a;
            line-height: 1.6;
        }

        nav{
            overflow-x: hidden;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000; /* Ensures the nav bar is above other content */
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding-left: 20%;
            overflow: hidden;
            background-color: #ffffff;
            
        }

        nav ul li {
            float: left;
            margin:3px;
        }

        nav ul li a {
            display: block;
            color: black;
            text-align: center;
            padding: 16px 18px;
            text-decoration: none;
        }

        /* Style for hovered link */
        nav ul li a:hover {
            color: rgb(229, 34, 115);
        }

        /* Style for active link (can be manually set) */
        nav ul li a.active {
            border-bottom: 8px solid rgb(229, 34, 115); /* Pink underline for active link */
        }

        h1{
            color:black;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color:  #CBF1F9;
            color: black;
            padding: 40px 30px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            height:100vh;
            font-family: 'Kalam', cursive;
            position:fixed;
            top:0;
            left:0;
            z-index: 500;
            
        }

        .sidebar h2 {
            margin-bottom: 40px;
            font-size: 24px;
            font-weight: 600;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 10px;
            width: 100%;
        }

        .sidebar a {
            color: black;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s ease;
            padding: 7px;
            width: 100%;
            border-radius: 5px;
            display:flex ; 
            gap:10px;
            align-items: center;
        }

        .sidebar a:hover {
            color:#E14177;
            background-color: white;
            padding:7px;
            
        }

        .sidebar a.active{
            color:#E14177;
            background-color: white;
        }

        /* css styling for icons */
        .sidebar ul li i {
            font-size: 14px;           /* Adjust icon size as needed */
            color: black;               /* Optional: match icon color with text */
        }

        /* Layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            margin-left:250px;
            margin-top:60px;
            
        }

        /* Header Section */
        .header-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .profile-section {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .welcome-text h1 {
            font-size: 2rem;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .welcome-text p {
            color: #666;
            margin-bottom: 2rem;
        }

        .user-info {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .user-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #e5e7eb;
        }

        .user-details h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .user-details p {
            color: #666;
            margin-bottom: 0.5rem;
        }

        .points {
            color: #0288d1;
            font-weight: 600;
        }

        .find-tutor-btn {
            margin-top: 1rem;
            background: #E14177;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .find-tutor-btn:hover {
            background: #e02362;
        }

        /* Calendar Section */
        .calendar-section {
            background: #CBF1F9;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .calendar-nav {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: #1a1a1a;
            padding: 0.5rem;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
            text-align: center;
        }

        .calendar-day-name {
            font-weight: 600;
            color: #666;
            font-size: 0.875rem;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .calendar-day:hover {
            background: white;
        }

        .calendar-day.selected {
            background: #4dd0e1;
            color: white;
            font-weight: 600;
        }

        /* Events and Feedback Section */
        .content-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .events-section, .feedback-section {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .view-all {
            color: #666;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .event-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .event-card {
            background: #e0f7fa;
            padding: 1rem;
            border-radius: 0.5rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            text-align: center;
        }

        .feedback-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .feedback-item {
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .feedback-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
        }

        .feedback-content {
            flex: 1;
        }

        .feedback-text {
            margin-bottom: 0.5rem;
            font-style: italic;
            color: #1a1a1a;
        }

        .feedback-date {
            font-size: 0.875rem;
            color: #666;
        }
    </style>
</head>
<body>
<?php include '../src/Views/navbar.php'; ?>
    <div class="container">
    <?php include 'sidebar.php'; ?>
        <div class="header-container">
            <div class="profile-section">
                <div class="welcome-text">
                    <h1>Welcome back, Sachini</h1>
                    <p>Keep up the good work!</p>
                </div>
                <div class="user-info">
                    <img src="images/student-uploads/stu2.jpg" alt="Profile" class="user-avatar">
                    <div class="user-details">
                        <h2>Sachini Wimalasiri</h2>
                        <p>Sachini10@gmail.com</p>
                        <p class="points">Points: 10,000</p>
                        <button class="find-tutor-btn"><a style="text-decoration:none; color:white;" href="student-findtutor">Find Tutor</a></button>
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
                    <a href="#" class="view-all">View All</a>
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
                    <a href="#" class="view-all">View All</a>
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
                    <a href="#" class="view-all">View All</a>
                </div>
                <div class="feedback-list">
                    <div class="feedback-item">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150" alt="Tutor" class="feedback-avatar">
                        <div class="feedback-content">
                            <p class="feedback-text">"Good effort! Pay more attention to details."</p>
                            <p class="feedback-date">15 Aug 2024 - 4:50 PM</p>
                        </div>
                    </div>
                    <div class="feedback-item">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150" alt="Tutor" class="feedback-avatar">
                        <div class="feedback-content">
                            <p class="feedback-text">"Good progress, focus on improving presentation."</p>
                            <p class="feedback-date">15 Aug 2024 - 3:20 PM</p>
                        </div>
                    </div>
                    <div class="feedback-item">
                        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150" alt="Tutor" class="feedback-avatar">
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