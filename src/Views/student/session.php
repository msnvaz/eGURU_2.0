<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = "session";
include __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session</title>
    <link rel="stylesheet" href="css/student/session.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
    <link rel="stylesheet" href="css/student/nav.css">
   
</head>

<body>
    
    <?php include 'sidebar.php'; ?>
    
    <div class="request_container">
        <div class="tableheader">
            <div id="pending-tab" class="active" onclick="toggleRequests('pending')">Pending Requests</div>
            <div id="rejected-tab" onclick="toggleRequests('rejected')">Rejected Requests</div>
            <div id="cancelled-tab" onclick="toggleRequests('cancelled')">Cancelled Requests</div>
        </div>

        <!-- Pending Requests Table -->
        <div id="pending-requests" class="table-container">
            <table>
                <thead>
                    <tr>
                    <th>Request ID</th>
                        <th>Tutor</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="pending-requests-body">
                </tbody>
            </table>
        </div>

        <!-- Rejected Sessions Table -->
        <div id="rejected-sessions" class="table-container" style="display: none;">
            <table>
                <thead>
                    <tr>
                    <th>Request ID</th>
                        <th>Tutor</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="rejected-sessions-body">
                </tbody>
            </table>
        </div>

        <!-- Cancelled Sessions Table -->
        <div id="cancelled-sessions" class="table-container" style="display: none;">
            <table>
                <thead>
                    <tr>
                    <th>Request ID</th>
                        <th>Tutor</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="cancelled-sessions-body">
                </tbody>
            </table>
        </div>
    </div>

    <!-- Session Details Modal -->
    <div id="session-details-modal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div class="modal-content" style="background-color: white; margin: 10% auto; padding: 20px; width: 50%; max-width: 500px; border-radius: 8px;">
            <h2>Session Details</h2>
            <div id="session-details-content"></div>
            <button onclick="closeSessionDetails()" style="margin-top: 15px; padding: 8px 15px; background-color: #E14177; color: white; border: none; border-radius: 4px; cursor: pointer;">Close</button>
        </div>
    </div>

   <script src="js/student/session.js"></script>
</body>
</html>