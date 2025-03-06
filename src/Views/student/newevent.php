<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="css/student/newevent.css">
    <link rel="stylesheet" href="css/student/new.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">

</head>
<?php $page="event"; ?>
<body>
<?php include '../src/Views/student/header.php'; ?>
<div class="event-bodyform-container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
<!-- <script src="events.js"></script> -->
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
        
    <!-- Tabs -->
    <div class="tabs">
      <div class="tab active" id="upcoming-tab" onclick="showUpcoming()">Upcoming Events</div>
      <div class="tab" id="previous-tab" onclick="showPrevious()">Previous Events</div>
    </div>

    <!-- Event Tables -->
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
          <tr onclick="toggleDetails(this)">
            <td>Mathematics</td>
            <td>Grade 10</td>
            <td>Mr. Kavinda</td>
            <td>20 Dec 2024</td>
            <td>2:00 pm</td>
          </tr>
          <tr class="details-row">
            <td colspan="5">
              <ul>
                <li><strong>Tutor:</strong> Mr. Kavinda</li>
                <li><strong>Qualifications:</strong> B.Sc in Mathematics, 5+ years teaching experience</li>
                <li><strong>Time Slot:</strong> 2:00 pm - 3:00 pm</li>
                <li><strong>Topic:</strong> Algebra and Quadratic Equations</li>
                <li><strong>Other Details:</strong> Bring a notebook, pencil, and scientific calculator.</li>
              </ul>
            </td>
          </tr>
          <tr onclick="toggleDetails(this)">
            <td>Science</td>
            <td>Grade 10</td>
            <td>Mr. Dulanjaya</td>
            <td>21 Dec 2024</td>
            <td>10:00 am</td>
          </tr>
          <tr class="details-row">
            <td colspan="5">
              <ul>
                <li><strong>Tutor:</strong> Mr. Dulanjaya</li>
                <li><strong>Qualifications:</strong> M.Sc in Chemistry, 8+ years teaching experience</li>
                <li><strong>Time Slot:</strong> 10:00 am - 11:00 am</li>
                <li><strong>Topic:</strong> Chemical Equations</li>
                <li><strong>Other Details:</strong> Refer the "chemical equations" resource book</li>
              </ul>
            </td>
          </tr>
          <tr onclick="toggleDetails(this)">
            <td>English</td>
            <td>Grade 10</td>
            <td>Mr. Nuwan</td>
            <td>25 Dec 2024</td>
            <td>4:00 pm</td>
          </tr>
          <tr class="details-row">
            <td colspan="5">
              <ul>
                <li><strong>Tutor:</strong> Mr. Nuwan</li>
                <li><strong>Qualifications:</strong> 5+ years teaching experience</li>
                <li><strong>Time Slot:</strong> 4:00 pm - 5:00 pm</li>
                <li><strong>Topic:</strong> Grammer workbook exercises</li>
                <li><strong>Other Details:</strong> Bring a English textbook and workbook.</li>
              </ul>
            </td>
          </tr>
          <tr onclick="toggleDetails(this)">
            <td>ICT</td>
            <td>Grade 10</td>
            <td>Ms. Rithmi</td>
            <td>26 Dec 2024</td>
            <td>11:00 am</td>
          </tr>
          <tr class="details-row">
            <td colspan="5">
              <ul>
                <li><strong>Tutor:</strong> Ms. Rithmi</li>
                <li><strong>Qualifications:</strong> B.Sc Undergraduate at ucsc </li>
                <li><strong>Time Slot:</strong> 11:00 am - 12:00 pm</li>
                <li><strong>Topic:</strong> Logic Gates</li>
                <li><strong>Other Details:</strong> Remember to recall the Logic gate theory</li>
              </ul>
            </td>
          </tr>
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
          <tr onclick="toggleDetails(this)">
            <td>History</td>
            <td>Grade 10</td>
            <td>Mr. Lahiru</td>
            <td>22 Nov 2024</td>
            <td>2:00 pm</td>
          </tr>
          <tr class="details-row">
            <td colspan="5">
              <ul>
                <li><strong>Tutor:</strong> Mr. Lahiru</li>
                <li><strong>Qualifications:</strong> M.A in History, 6+ years teaching experience</li>
                <li><strong>Time Slot:</strong> 2:00 pm - 3:00 pm</li>
                <li><strong>Topic:</strong> World War II and Modern Geopolitics</li>
                <li><strong>Other Details:</strong> Recommended to read Chapter 7 of the textbook beforehand.</li>
              </ul>
            </td>
          </tr>
          <tr onclick="toggleDetails(this)">
            <td>Geography</td>
            <td>Grade 10</td>
            <td>Ms. Chathuri</td>
            <td>22 Nov 2024</td>
            <td>6:00 pm</td>
          </tr>
          <tr class="details-row">
            <td colspan="5">
              <ul>
                <li><strong>Tutor:</strong> Ms. Chathuri</li>
                <li><strong>Qualifications:</strong> B.Sc in Geography, 4+ years teaching experience</li>
                <li><strong>Time Slot:</strong> 6:00 pm - 7:00 pm</li>
                <li><strong>Topic:</strong> Climates and Ecosystems</li>
                <li><strong>Other Details:</strong> Bring your map and atlas for reference.</li>
              </ul>
            </td>
          </tr>
          <tr onclick="toggleDetails(this)">
            <td>English</td>
            <td>Grade 10</td>
            <td>Mr. Nuwan</td>
            <td>19 Nov 2024</td>
            <td>10:00 am</td>
          </tr>
          <tr class="details-row">
            <td colspan="5">
              <ul>
                <li><strong>Tutor:</strong> Mr. Nuwan</li>
                <li><strong>Qualifications:</strong> B.Sc in Engish Literature, 4+ years teaching experience</li>
                <li><strong>Time Slot:</strong> 10:00 am - 11:00 am</li>
                <li><strong>Topic:</strong> Vocabulary in the Text book</li>
                <li><strong>Other Details:</strong> Bring your school textbook and workbook.</li>
              </ul>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  
    <script src="js/student/newevent.js"></script>
</body>
</html>
