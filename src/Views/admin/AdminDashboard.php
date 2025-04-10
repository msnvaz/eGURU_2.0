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
                    <p class="stat-number"><?= $totalStudents ?></p>
                    <span class="stat-trend positive">+12% ↑</span>
                </div>
                <div class="stat-card">
                    <h3>Total Tutors</h3>
                    <p class="stat-number"><?= $totalTutors ?></p>
                    <span class="stat-trend positive">+5% ↑</span>
                </div>
                <div class="stat-card">
                    <h3>Total Sessions</h3>
                    <p class="stat-number"><?= $totalSessions ?></p>
                    <span class="stat-trend positive">+10% ↑</span>
                </div>
                <div class="stat-card">
                    <h3>Completed Sessions</h3>
                    <p class="stat-number"><?= $completedSessions ?></p>
                    <span class="stat-trend positive">+8% ↑</span>
                </div>
                <div class="stat-card">
                    <h3>Revenue</h3>
                    <p class="stat-number"><?= number_format($totalRevenue, 2) ?></p>
                    <span class="stat-trend positive">+8% ↑</span>
                </div>
                <div class="stat-card">
                    <h3>Total points in Student wallets</h3>
                    <p class="stat-number"><?= number_format($totalRevenue, 2) ?></p>
                    <span class="stat-trend positive">+8% ↑</span>
                </div>
                <div class="stat-card">
                    <h3>Revenue</h3>
                    <p class="stat-number"><?= number_format($totalRevenue, 2) ?></p>
                    <span class="stat-trend positive">+8% ↑</span>
                </div>
        </div>
        <div class="container mt-4">
            <!-- First row of charts -->
            <div class="row">
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Student Registrations</h3>
                        <canvas id="studentRegistrationsChart"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Tutor Registrations</h3>
                        <canvas id="teacherRegistrationsChart"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Sessions Per Subject</h3>
                        <canvas id="sessionsPerSubjectChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Second row of charts -->
            <div class="row">
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Session Status</h3>
                        <canvas id="sessionsStatusChart"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Teacher Performance</h3>
                        <canvas id="teacherPerformanceChart"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-container">
                        <h3>Student Feedback</h3>
                        <canvas id="studentFeedbackChart"></canvas>
                    </div>
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
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Student Registrations',
                    data: <?= json_encode($studentRegistrationsByMonth ?? [0,0,0,0,0,0,0,0,0,0,0,0]) ?>,
                    borderColor: '#293241',
                    backgroundColor: 'rgba(74, 144, 226, 0.2)',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    
        // Teacher Registrations Over Time
        const teacherRegistrationsCtx = document.getElementById('teacherRegistrationsChart').getContext('2d');
        new Chart(teacherRegistrationsCtx, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Tutor Registrations',
                    data: <?= json_encode($tutorRegistrationsByMonth ?? [0,0,0,0,0,0,0,0,0,0,0,0]) ?>,
                    borderColor: '#ee6c4d',
                    backgroundColor: 'rgba(255, 182, 193, 0.2)',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    
        // Sessions Per Subject
        const sessionsPerSubjectCtx = document.getElementById('sessionsPerSubjectChart').getContext('2d');
        new Chart(sessionsPerSubjectCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode(array_column($sessionsPerSubject ?? [], 'subject_name')) ? : '[]' ?>,
                datasets: [{
                    label: 'Sessions',
                    data: <?= json_encode(array_column($sessionsPerSubject ?? [], 'total')) ? : '[]' ?>,
                    backgroundColor: [
                        '#3d5a80', '#98c1d9', '#e0fdfc', '#ee6c4d', '#293241',
                        '#3d5a80', '#98c1d9', '#e0fdfc', '#ee6c4d', '#293241',
                        '#3d5a80', '#98c1d9'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    
        // Sessions Status
        const sessionsStatusCtx = document.getElementById('sessionsStatusChart').getContext('2d');
        new Chart(sessionsStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Scheduled', 'Completed', 'Cancelled', 'Requested', 'Rejected'],
                datasets: [{
                    data: [
                        <?= $sessionData['scheduled'] ?? 0 ?>, 
                        <?= $sessionData['completed'] ?? 0 ?>, 
                        <?= $sessionData['cancelled'] ?? 0 ?>,
                        <?= $sessionData['requested'] ?? 0 ?>,
                        <?= $sessionData['rejected'] ?? 0 ?>
                    ],
                    backgroundColor: ['#8ecae6', '#023047', '#ffb703', '#219ebc', '#fb8500']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    
        // Teacher Performance (Using sample data for now)
        const teacherPerformanceCtx = document.getElementById('teacherPerformanceChart').getContext('2d');
        new Chart(teacherPerformanceCtx, {
            type: 'polarArea',
            data: {
                labels: ['Teacher A', 'Teacher B', 'Teacher C', 'Teacher D'],
                datasets: [{
                    data: [80, 90, 70, 85], // Replace with real data when available
                    backgroundColor: [
                        'rgba(142, 202, 230, 0.7)',
                        'rgba(2, 48, 71, 0.7)',
                        'rgba(255, 183, 3, 0.7)',
                        'rgba(253, 133, 0, 0.7)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    
        // Student Feedback
        const studentFeedbackCtx = document.getElementById('studentFeedbackChart').getContext('2d');
        // Get feedback data or use defaults
        const feedbackData = {
            punctuality: <?= isset($feedbackData['punctuality']) ? $feedbackData['punctuality'] : 4.2 ?>,
            knowledge: <?= isset($feedbackData['knowledge']) ? $feedbackData['knowledge'] : 5.0 ?>,
            clarity: <?= isset($feedbackData['clarity']) ? $feedbackData['clarity'] : 4.5 ?>,
            engagement: <?= isset($feedbackData['engagement']) ? $feedbackData['engagement'] : 3.8 ?>,
            helpfulness: <?= isset($feedbackData['helpfulness']) ? $feedbackData['helpfulness'] : 4.8 ?>
        };
        
        new Chart(studentFeedbackCtx, {
            type: 'radar',
            data: {
                labels: ['Punctuality', 'Knowledge', 'Clarity', 'Engagement', 'Helpfulness'],
                datasets: [{
                    label: 'Feedback Score',
                    data: [
                        feedbackData.punctuality,
                        feedbackData.knowledge,
                        feedbackData.clarity,
                        feedbackData.engagement,
                        feedbackData.helpfulness
                    ],
                    backgroundColor: 'rgba(74, 144, 226, 0.4)',
                    borderColor: '#4A90E2',
                    borderWidth: 1.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        min: 0,
                        max: 5
                    }
                }
            }
        });
    </script>
    
    <style>
        /* Copy and paste the CSS provided in the artifact above */
    </style>
</body>
</html>