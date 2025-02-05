<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kalam:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <br>
        <!-- Statistics Overview -->
        <div class="stats-section">
                <div class="stat-card">
                    <h3>Total Students</h3>
                    <p class="stat-number">2,547</p>
                    <span class="stat-trend positive">+12% ↑</span>
                </div>
                <div class="stat-card">
                    <h3>Total Teachers</h3>
                    <p class="stat-number">157</p>
                    <span class="stat-trend positive">+5% ↑</span>
                </div>
                <div class="stat-card">
                    <h3>Active Sessions</h3>
                    <p class="stat-number">48</p>
                    <span class="stat-trend">Today</span>
                </div>
                <div class="stat-card">
                    <h3>Revenue</h3>
                    <p class="stat-number">Rs.105,280</p>
                    <span class="stat-trend positive">+8% ↑</span>
                </div>
        </div>
        <div class="container mt-4">
            <div class="row">
            <div class="col-md-4 mb-4">
                <canvas id="studentRegistrationsChart"></canvas>
            </div>
            <div class="col-md-4 mb-4">
                <canvas id="teacherRegistrationsChart"></canvas>
            </div>
            <div class="col-md-4 mb-4">
                <canvas id="sessionsPerSubjectChart"></canvas>
            </div>
            </div>
            <div class="row">
            <div class="col-md-4 mb-4">
                <canvas id="sessionsStatusChart"></canvas>
            </div>
            <div class="col-md-4 mb-4">
                <canvas id="teacherPerformanceChart"></canvas>
            </div>
            <div class="col-md-4 mb-4">
                <canvas id="studentFeedbackChart"></canvas>
            </div>
            </div>
        </div>
    </div>

    <script>
        // Student Registrations Over Time
        const studentRegistrationsCtx = document.getElementById('studentRegistrationsChart').getContext('2d');
        new Chart(studentRegistrationsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], 
                datasets: [{
                    label: 'Student Registrations',
                    data: [50, 70, 80, 120, 150, 180],
                    borderColor: '#293241', // Blue
                    backgroundColor: 'rgba(74, 144, 226, 0.2)', // Light Blue (semi-transparent)
                    borderWidth: 2,
                }]
            }
        });
    
        // Teacher Registrations Over Time
        const teacherRegistrationsCtx = document.getElementById('teacherRegistrationsChart').getContext('2d');
        new Chart(teacherRegistrationsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], 
                datasets: [{
                    label: 'Teacher Registrations',
                    data: [10, 20, 15, 25, 30, 40],
                    borderColor: '#ee6c4d', // Light Pink
                    backgroundColor: 'rgba(255, 182, 193, 0.2)', // Light Pink (semi-transparent)
                    borderWidth: 2,
                }]
            }
        });
    
        // Sessions Per Subject
        const sessionsPerSubjectCtx = document.getElementById('sessionsPerSubjectChart').getContext('2d');
        new Chart(sessionsPerSubjectCtx, {
            type: 'bar',
            data: {
                labels: ['Math', 'Science', 'English', 'History', 'Art'], 
                datasets: [{
                    label: 'Sessions',
                    data: [100, 80, 120, 60, 40],
                    backgroundColor: ['#3d5a80', '#98c1d9', '#e0fdfc', '#ee6c4d', '#293241'], // Various shades of blue and pink
                }]
            }
        });
    
        // Sessions Status
        const sessionsStatusCtx = document.getElementById('sessionsStatusChart').getContext('2d');
        new Chart(sessionsStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending', 'Cancelled'], 
                datasets: [{
                    data: [60, 30, 10],
                    backgroundColor: ['#8ecae6', '#023047', '#ffb703'], // Blue, Light Pink, Light Blue
                }]
            }
        });
    
        // Teacher Performance
        const teacherPerformanceCtx = document.getElementById('teacherPerformanceChart').getContext('2d');
        new Chart(teacherPerformanceCtx, {
            type: 'polarArea',
            data: {
                labels: ['Teacher A', 'Teacher B', 'Teacher C', 'Teacher D'], 
                datasets: [{
                    data: [80, 90, 70, 85],
                    backgroundColor: [
                        'rgba(142, 202, 230, 0.7)', // Light Blue
                        'rgba(2, 48, 71, 0.7)',     // Dark Blue
                        'rgba(255, 183, 3, 0.7)',   // Yellow
                        'rgba(253, 133, 0, 0.7)'    // Orange
                        ]
                        // Blue and Pink shades
                }]
            }
        });
    
        // Student Feedback
        const studentFeedbackCtx = document.getElementById('studentFeedbackChart').getContext('2d');
        new Chart(studentFeedbackCtx, {
            type: 'radar',
            data: {
                labels: ['Punctuality', 'Knowledge', 'Clarity', 'Engagement', 'Helpfulness'], 
                datasets: [{
                    label: 'Feedback Score',
                    data: [4.2, 5, 4.5, 3.8, 4.8],
                    backgroundColor: 'rgba(74, 144, 226, 0.4)', // Light Blue (semi-transparent)
                    borderColor: '#4A90E2', // Blue
                    borderWidth: 1.5
                }]
            }
        });
    </script>
    
</body>
</html>
