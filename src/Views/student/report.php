<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Tutor</title>
    <link rel="stylesheet" href="css/student/report.css">
    <link rel="stylesheet" href="css/student/new.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
</head>
<?php $page="report"; ?>
<body>
<?php include '../src/Views/navbar.php'; ?>

        <?php include 'sidebar.php'; ?>
    <div class="report-container">
        <h2>Report a Tutor</h2>
        <p>If you have experienced any issues with a tutor, please fill out the form below and let us know what happened.</p><br>

        <form action="/student/save-report" method="post">
    <!-- Tutor selection -->
    <label for="tutor_id">Select Tutor_ID:</label>
    <select id="tutor_id" name="tutor_id" required>
        <option value="" disabled selected>Select tutor_id</option>
        <option value="1">Mr. Kavinda-101</option>
        <option value="2">Mr. Dulanjaya-102</option>
        <option value="4">Mr. Nuwan-103</option>
        <option value="7">Ms. Chathuri-104</option>
    </select>

    <!-- Issue type -->
    <label for="issue_type">Issue Type:</label>
    <select id="issue_type" name="issue_type" required>
        <option value="" disabled selected>Select the issue</option>
        <option value="misconduct">Misconduct</option>
        <option value="inappropriate_behavior">Inappropriate Behavior</option>
        <option value="unprofessionalism">Unprofessionalism</option>
        <option value="other">Other</option>
    </select>

    <!-- Detailed description -->
    <label for="description">Description of the Issue:</label>
    <textarea id="description" name="description" rows="6" placeholder="Please describe the issue in detail..." required></textarea>

    <!-- Submit button -->
    <button type="submit" class="report-button">Submit Report</button>


        </form>
    </div>
    <div class="reports-list">
    <h3>Your Previous Reports</h3>
    <?php if (!empty($data)): ?>
        <table class="reports-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Tutor ID</th>
                    <th>Issue Type</th>
                    <th>Status</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($report['created_at']))); ?></td>
                        <td><?php echo htmlspecialchars($report['tutor_id']); ?></td>
                        <td><?php echo htmlspecialchars($report['issue_type']); ?></td>
                        <td><?php echo htmlspecialchars($report['status']); ?></td>
                        <td><?php echo htmlspecialchars($report['description']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No reports submitted yet.</p>
    <?php endif; ?>
</div>
</body>
</html>
