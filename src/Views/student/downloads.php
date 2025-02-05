<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloads</title>
    <link rel="stylesheet" href="css/student/new.css">
</head>
<?php $page="download"; ?>
<body>
    
<?php include '../src/Views/navbar.php'; ?>

        <?php include 'sidebar.php'; ?>
<div class="download-bodyform">
<!-- Content area -->
<div id="download-content">
        <h1>Download Study Materials</h1><br>

        <!-- Dropdown for grade and subject -->
        <div class="selection">
            <label for="grade">Grade:</label>
            <select id="grade">
                <option value="grade6">Grade 6</option>
                <option value="grade7">Grade 7</option>
                <option value="grade8">Grade 8</option>
                <option value="grade9">Grade 9</option>
                <option value="grade10">Grade 10</option>
                <option value="grade11">Grade 11</option>
            </select>
            <br><br>
            <label for="subject">Subject:</label>
            <select id="subject">
                <option value="math">Math</option>
                <option value="science">Science</option>
                <option value="history">History</option>
                <option value="ict">ICT</option>
                <option value="geography">Geography</option>
                <option value="english">English</option>
            </select>
<br><br>
            <button class="btn" onclick="loadMaterials()">Show Materials</button>
        </div>

        <!-- List of study materials -->
        <ul id="materialList" class="materials">
            <!-- Dynamically filled by JS -->
        </ul>
    </div>
</div>
    <script src="js/student/downloads.js"></script>
</body>
</html>
