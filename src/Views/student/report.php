<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Tutor</title>
    <link rel="stylesheet" href="css/student/new.css">
</head>
<?php $page="report"; ?>
<body>
<?php include '../src/Views/navbar.php'; ?>

        <?php include 'sidebar.php'; ?>
    <div class="report-container">
        <h2>Report a Tutor</h2>
        <p>If you have experienced any issues with a tutor, please fill out the form below and let us know what happened.</p><br>

        <form action="#" method="post">
            <!-- Tutor selection -->
            <label for="tutor">Select Tutor:</label>
            <select id="tutor" name="tutor" required>
                <option value="" disabled selected>Select a tutor</option>
                <option value="tutor1">Mr. Kavinda</option>
                <option value="tutor2">Mr. Dulanjaya</option>
                <option value="tutor4">Mr. Nuwan</option>
                <option value="tutor7">Ms. Chathuri</option>
                <!-- Add more tutor options as needed -->
            </select>

            <!-- Issue type -->
            <label for="issue">Issue Type:</label>
            <select id="issue" name="issue" required>
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
</body>
</html>
