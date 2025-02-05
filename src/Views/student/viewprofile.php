<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/student/new.css">
    
</head>
<?php $page="profile"; ?>
<body>
<?php include '../src/Views/navbar.php'; ?>
<!-- header part here -->
    <div class="container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

<div class="profile-bodyform">
        <div class="viewprofile-content">
            <div class="viewprofile-header">
                <img src="images/student-uploads/stu2.jpg" alt="Profile Image" class="viewprofile-img">
                <h1>Sachini Wimalasiri</h1>
                <button class="edit-button"><a style="text-decoration:none; color:white;" href="student-profile">Edit Profile</a></button>
            </div>
            <div class="viewprofile-details">
                <div class="detail-item"><strong>Bio:</strong> Sachini is a 10th-grade student from Colombo, Srilanka, with a passion for science, technology, and creative arts.</div><br>
                <div class="detail-item"><strong>Education:</strong> 10th Grade, Hindhu National College Colombo</div><br>
                <div class="detail-item"><strong>Contact Information:</strong> Phone: 123-456-7890<br>Email: Sachini10@gmail.com</div><br>
                <div class="detail-item"><strong>Country:</strong> Srilanka</div><br>
                <div class="detail-item"><strong>City/Town:</strong> Colombo</div><br>
                <div class="detail-item"><strong>Interests:</strong> Coding and robotics<br>Basketball and swimming<br>Drawing and digital art<br>Reading and writing stories</div><br>
                <div class="detail-item"><strong>Grade:</strong> 10th Grade</div><br>
            </div>
        </div>

</div>
    </body>
    </html>
    