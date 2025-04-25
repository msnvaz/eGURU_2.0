<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = "viewprofile";
include __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/student/viewprofile.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">

</head>


<body>

    <!-- header part here -->
    <div class="container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; 
        $_SESSION['profile_picture'] = $profileData['student_profile_photo'] ?? 'profile1.jpg'; ?>

        <div class="profile-bodyform">
            <div class="viewprofile-content">
                <div class="viewprofile-header">
                <img src="/images/student-uploads/profilePhotos/<?php echo isset($_SESSION['profile_picture']) ? htmlspecialchars($_SESSION['profile_picture']) : 'profile1.jpg'; ?>"
                alt="Profile Image" class="viewprofile-img">
                    <h1><?= isset($_SESSION['student_name']) ? htmlspecialchars($_SESSION['student_name']) : 'Student Name' ?></h1>
                    <button class="edit-button"><a style="text-decoration:none; color:white;"
                            href="/student-profile-edit"><?php echo $profileData ? "Edit profile" : "Create profile"; ?></a></button>
                    <form action="/student-profile-delete" method="POST" style="display:inline;">
                        <button type="submit" class="delete-button" >Delete Profile</button>
                    </form>
                </div>

                <div class="viewprofile-details">
                    <div class="detail-item"><strong>Bio:</strong> <?= $profileData['bio'] ?? 'N/A' ?></div><br>
                    <div class="detail-item"><strong>Education:</strong> <?= $profileData['education'] ?? 'N/A' ?></div><br>
                    <div class="detail-item"><strong>Contact Information:</strong> Phone:
                        <?= $profileData['student_phonenumber'] ?? 'N/A' ?><br>Email: <?= $profileData['student_email'] ?? 'N/A' ?></div><br>
                    <div class="detail-item"><strong>Country:</strong> <?= $profileData['country'] ?? 'N/A' ?></div><br>
                    <div class="detail-item"><strong>City/Town:</strong> <?= $profileData['city_town'] ?? 'N/A' ?></div><br>
                    <div class="detail-item"><strong>Interests:</strong> <?= $profileData['interests'] ?? 'N/A' ?></div><br>
                    <div class="detail-item"><strong>Grade:</strong> <?= $profileData['student_grade'] ?? 'N/A' ?></div><br>
                </div>

            </div>

        </div>


</body>

</html>