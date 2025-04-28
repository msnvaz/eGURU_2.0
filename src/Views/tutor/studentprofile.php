<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU student profile</title>
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link rel="stylesheet" href="/css/tutor/studentprofile.css">
    <style>
    </style>
</head>

<body>
    
    <?php include 'sidebar.php'; ?>

   
    <?php include '../src/Views/tutor/header.php'; ?>


    <div class="bodyform">
        
        <div class="profile-content">
            <div class="viewprofile-header">
                <div class="profile-picture">
                    <img src="/images/student-uploads/profilePhotos/<?php echo isset($profileData['student_profile_photo']) ? $profileData['student_profile_photo'] : 'profile1.jpg'; ?>" alt="Profile Picture">
                </div>
                    <h1>
                        <?= isset($profileData['student_first_name'], $profileData['student_last_name']) ? htmlspecialchars($profileData['student_first_name'] . ' ' . $profileData['student_last_name'])  : 'Student Name' ?>
                    </h1>
            </div>

            <div class="profile-section">
                <div class="section-row">
                    <div class="section-box">
                        <h3>Bio</h3>
                        <p><?php echo $profileData['bio'] ?? 'N/A'; ?></p>
                    </div>
                    <div class="section-box">
                        <h3>Education</h3>
                        <p><?php echo $profileData['education'] ?? 'N/A'; ?></p>
                    </div>
                </div>

                <div class="section-row">
                    <div class="section-box">
                        <h3>Contact Information</h3>
                        <p><strong>Phone:</strong> <?php echo $profileData['student_phonenumber'] ?? 'N/A'; ?></p>
                        <p><strong>Email:</strong> <?php echo $profileData['student_email'] ?? 'N/A'; ?></p>
                    </div>
                    <div class="section-box">
                        <h3>Interests</h3>
                        <p><?php echo $profileData['interests'] ?? 'N/A'; ?></p>
                    </div>
                </div>

                <div class="section-row">
                    <div class="section-box">
                        <h3>Country</h3>
                        <p><?php echo $profileData['country'] ?? 'N/A'; ?></p>
                    </div>
                    <div class="section-box">
                        <h3>City/Town</h3>
                        <p><?php echo $profileData['city_town'] ?? 'N/A'; ?></p>
                    </div>
                </div>

                <div class="section-row">
                    <div class="section-box">
                        <h3>Grade</h3>
                        <p><?php echo $profileData['student_grade'] ?? 'N/A'; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
