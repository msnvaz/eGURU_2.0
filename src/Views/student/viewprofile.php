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
                    <img src="images/student-uploads/profilePhotos/<?= $profileData['profile_picture']?>"
                        alt="Profile Image" class="viewprofile-img">
                    <h1>Sachini Wimalasiri</h1>
                    <button class="edit-button"><a style="text-decoration:none; color:white;"
                            href="/student-profile-edit"><?php echo $profileData ? "Edit profile" : "Create profile"; ?></a></button>
                </div>



                <div class="viewprofile-details">
                    <div class="detail-item"><strong>Bio:</strong> <?= $profileData['bio'] ?></div><br>
                    <div class="detail-item"><strong>Education:</strong> <?= $profileData['education'] ?></div><br>
                    <div class="detail-item"><strong>Contact Information:</strong> Phone:
                        <?= $profileData['phone'] ?><br>Email: <?= $profileData['email'] ?></div><br>
                    <div class="detail-item"><strong>Country:</strong> <?= $profileData['country'] ?></div><br>
                    <div class="detail-item"><strong>City/Town:</strong> <?= $profileData['city_town'] ?></div><br>
                    <div class="detail-item"><strong>Interests:</strong> <?= $profileData['interests'] ?></div><br>
                    <div class="detail-item"><strong>Grade:</strong> <?= $profileData['grade'] ?></div><br>
                </div>

            </div>

        </div>


</body>

</html>