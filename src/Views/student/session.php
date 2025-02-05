<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Requests</title>
    <link rel="stylesheet" href="css/student/session.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
    
</head>
<?php $page="session"; ?>
<body>
<?php include '../src/Views/navbar.php'; ?>

        <?php include 'sidebar.php'; ?>
        <div class="request_container">
    <div class="header">
      <div id="pending-tab" class="active" onclick="toggleRequests('pending')">Pending requests</div>
      <div id="results-tab" onclick="toggleRequests('results')">Request results</div>
    </div>

    <!-- Pending Requests Table -->
    <div id="pending-requests" class="table-container">
      <table>
        <thead>
          <tr>
            <th>Tutor</th>
            <th>Subject</th>
            <th>Grade</th>
            <th>Requested At</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor1.jpg" alt="Tutor" class="tutor-img">
                Mr. Kavinda
              </div>
            </td>
            <td>ICT</td>
            <td>Grade 10</td>
            <td>2 hours ago</td>
            <td><button class="btn-pending" onclick="cancelRequest(this)">Pending</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor2.jpg" alt="Tutor" class="tutor-img">
                Mr. Kumar
              </div>
            </td>
            <td>Mathematics</td>
            <td>Grade 10</td>
            <td>4 hours ago</td>
            <td><button class="btn-pending" onclick="cancelRequest(this)">Pending</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor3.jpg" alt="Tutor" class="tutor-img">
                Mr. Anura
              </div>
            </td>
            <td>Agriculture</td>
            <td>Grade 10</td>
            <td>9 hours ago</td>
            <td><button class="btn-pending" onclick="cancelRequest(this)">Pending</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor4.jpg" alt="Tutor" class="tutor-img">
                Mr. Ravindhu
              </div>
            </td>
            <td>Sinhala</td>
            <td>Grade 10</td>
            <td>12 hours ago</td>
            <td><button class="btn-pending" onclick="cancelRequest(this)">Pending</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor5.jpg" alt="Tutor" class="tutor-img">
                Mr. Wimal
              </div>
            </td>
            <td>English</td>
            <td>Grade 10</td>
            <td>13 hours ago</td>
            <td><button class="btn-pending" onclick="cancelRequest(this)">Pending</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor6.jpg" alt="Tutor" class="tutor-img">
                Mr. Kavinda
              </div>
            </td>
            <td>ICT</td>
            <td>Grade 10</td>
            <td>19 hours ago</td>
            <td><button class="btn-pending" onclick="cancelRequest(this)">Pending</button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Request Results Table -->
    <div id="request-results" class="table-container hidden">
      <table>
        <thead>
          <tr>
            <th>Tutor</th>
            <th>Subject</th>
            <th>Grade</th>
            <th>Requested At</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor7.jpg" alt="Tutor" class="tutor-img">
                Ms. Chathuri
              </div>
            </td>
            <td>Geography</td>
            <td>Grade 10</td>
            <td>3 hours ago</td>
            <td><button class="btn-approved" onclick="showApprovedPopup('Ms. Chathuri', '3.30pm - 4.40pm', 'Geography', '123-456-789', 'password123')">Approved</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor6.jpg" alt="Tutor" class="tutor-img">
                Mr. Lahiru
              </div>
            </td>
            <td>History</td>
            <td>Grade 10</td>
            <td>5 hours ago</td>
            <td> <button class="btn-approved" onclick="showApprovedPopup('Mr. Lahiru', '11.00a.m - 12.00pm', 'History', '789-123-456', 'mypassword')">Approved</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor6.jpg" alt="Tutor" class="tutor-img">
                Mr. Lahiru
              </div>
            </td>
            <td>History</td>
            <td>Grade 10</td>
            <td>5 hours ago</td>
            <td><button class="btn-declined">Declined</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor8.jpg" alt="Tutor" class="tutor-img">
                Mr. John
              </div>
            </td>
            <td>Mathematics</td>
            <td>Grade 10</td>
            <td>8 hours ago</td>
            <td> <button class="btn-approved" onclick="showApprovedPopup('Mr. John', '2.00p.m - 3.00pm', 'Mathematics', '589-123-456', 'mypassword')">Approved</button></td>
          </tr>
          <tr>
            <td>
              <div class="tutor-info">
                <img src="images/student-uploads/tutor6.jpg" alt="Tutor" class="tutor-img">
                Mr. Lahiru
              </div>
            </td>
            <td>History</td>
            <td>Grade 10</td>
            <td>11 hours ago</td>
            <td> <button class="btn-approved" onclick="showApprovedPopup('Mr. Lahiru', '3.00pm - 4.00pm', 'History', '789-123-456', 'mypassword')">Approved</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


  <!-- Approved Popup -->
  <div class="approved_popup-overlay" id="approved_popup">
    <div class="approved_popup-content">
      <h2>Session Details</h2>
      <p><strong>Tutor:</strong> <span id="approved_popup-tutor"></span></p>
      <p><strong>Time:</strong> <span id="approved_popup-time"></span></p>
      
      <p><strong>Meeting ID:</strong> <span id="approved_popup-meeting-id"></span></p>
      <p><strong>Meeting Password:</strong> <span id="approved_popup-password"></span></p>
      <p><a id="approved_popup-link" href="https://meet.google.com" target="_blank">Join Google Meet</a></p>
      <button class="close-btn" onclick="closeApprovedPopup()">Close</button>
    </div>
  </div>

    <script src="js/student/session.js"></script>
</body>
</html>
