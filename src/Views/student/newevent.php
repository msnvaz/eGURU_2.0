<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = "event";
include __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="/css/student/newevent.css">
    <link rel="stylesheet" href="/css/student/nav.css">
    <link rel="stylesheet" href="/css/student/sidebar.css">
    
</head>
<body>
    <div class="event-bodyform-container">
        <?php include __DIR__ . '/sidebar.php'; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error-message">
                <?php 
                    echo $_SESSION['error_message']; 
                    unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>

        <div class="calendars">
            <div class="calendar" id="prev-month-calendar">
                <div class="calendar-header">
                    <div id="prev-month-year"></div>
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
                    <div id="prev-days" class="days"></div>
                </div>
            </div>
            <div class="calendar" id="current-month-calendar">
                <div class="calendar-header">
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
            <div class="calendar" id="next-month-calendar">
                <div class="calendar-header">
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

        <div class="event-table-container">
            <div class="tabs">
                <div class="tab active" id="upcoming-tab" onclick="showUpcoming()">Upcoming Events</div>
                <div class="tab" id="previous-tab" onclick="showPrevious()">Previous Events</div>
            </div>

            <div id="upcoming-events" class="events">
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
                        <?php if (!empty($upcomingEvents)): ?>
                            <?php foreach ($upcomingEvents as $event): ?>
                            <tr class="event-row" onclick="viewEventDetails(<?php echo htmlspecialchars(json_encode($event)); ?>)">
                                <td><?php echo htmlspecialchars($event['subject_name']); ?></td>
                                <td><?php echo htmlspecialchars($event['grade'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($event['tutor_name'] ?? 'N/A'); ?></td>
                                <td><?php echo date('d M Y', strtotime($event['scheduled_date'])); ?></td>
                                <td><?php echo date('g:i a', strtotime($event['schedule_time'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No upcoming events available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="previous-events" class="events" style="display: none;">
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
                        <?php if (!empty($previousEvents)): ?>
                            <?php foreach ($previousEvents as $event): ?>
                            <tr class="event-row" onclick="viewEventDetails(<?php echo htmlspecialchars(json_encode($event)); ?>)">
                                <td><?php echo htmlspecialchars($event['subject_name']); ?></td>
                                <td><?php echo htmlspecialchars($event['grade'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($event['tutor_name'] ?? 'N/A'); ?></td>
                                <td><?php echo date('d M Y', strtotime($event['scheduled_date'])); ?></td>
                                <td><?php echo date('g:i a', strtotime($event['schedule_time'])); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No previous events available.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div id="event-details-modal" class="modal">
        <div class="modal-content">
            <h2>Event Details</h2>
            <div id="event-details-content"></div>
            <button onclick="closeEventDetails()" class="close-btn">Close</button>
        </div>
    </div>

    
    <script src="/js/student/newevent.js"></script>
</body>
</html>