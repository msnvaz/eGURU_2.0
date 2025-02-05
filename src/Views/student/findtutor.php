<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Finder</title>
    <link rel="stylesheet" href="css/student/new.css">
      
</head>
<body>
<?php include '../src/Views/navbar.php'; ?>

<?php include 'sidebar.php'; ?>
<div class="findtutor-bodyform">
    <!-- Search Section -->
    <div>
        <select>
            <option value="">Select Grade</option>
            <option value="Grade 10">Grade 10</option>
            <option value="Grade 11">Grade 11</option>
        </select>
        <select>
            <option value="">Select Subject</option>
            <option value="Math">Math</option>
            <option value="Science">Science</option>
        </select>
        <select>
            <option value="">Select Experience</option>
            <option value="1 Year">1 Year</option>
            <option value="2 Years">2 Years</option>
            
        </select>
        <button onclick="searchTutors()">Search</button>
    </div>

    <div id="results" class="results-container"></div>

    <!-- Popup -->
    <div id="findtutorpopup" class="findtutorpopup-overlay">
        <div class="findtutorpopup-content">
            <h2 id="findtutorpopup-name"></h2>
            <p id="findtutorpopup-qualification"></p>
            <p id="findtutorpopup-experience"></p>
            <button onclick="requestTutor()">Request</button>
            <button onclick="closePopup()">Close</button>
        </div>
    </div>



    <script src="js/student/findtutor.js"></script>
        
    
</body>
</html>
