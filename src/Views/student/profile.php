<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = "profile";
include __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/student/profile.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">

</head>


<body>

    <!-- header part here -->
    <div class="container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <div class="bodyform">
            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Profile Form -->
                <form action="/student-profile-updated" method="POST" enctype="multipart/form-data">
                    <div class="profile-picture edit-profile-picture" style="display: flex; flex-direction:column; align-items: center;margin-left:32%;">
                        <img id="profile-image"
                            src="images/student-uploads/profilePhotos/<?php echo $studentProfilePhoto; ?>"
                            alt="Profile Picture">
                        <label class="edit-change-photo-btn" for="file-input">Change Profile Photo</label>
                        <input type="file" id="file-input" name="profile-image" accept="image/*">
                                  
                    </div>


                    <div class="profile-section">
                        <div class="section-row">
                            <div class="section-box">
                                <h3>Bio</h3>
                                <textarea name="bio"
                                    placeholder="Enter your bio"><?php echo $profileData['bio'] ?? ''; ?></textarea>
                            </div>
                            <div class="section-box">
                                <h3>Education</h3>
                                <textarea name="education"
                                    placeholder="Enter your education details"><?php echo $profileData['education'] ?? ''; ?></textarea>
                            </div>
                        </div>
                        <div class="section-row">
                            <div class="section-box">
                                <h3>Contact Information</h3>
                                <input type="text" name="phone" placeholder="Enter phone number"
    value="<?php echo $profileData['student_phonenumber'] ?? ''; ?>">
<input type="email" name="email" placeholder="Enter email"
    value="<?php echo $profileData['student_email'] ?? ''; ?>">
</div>
                            <div class="section-box">
                                <h3>Interests</h3>
                                <textarea name="interests"
                                    placeholder="Enter your interests"><?php echo $profileData['interests'] ?? ''; ?></textarea>
                            </div>
                        </div>

                        <div class="section-row">
                            <div class="section-box">
                                <h3>Country</h3>
                                <input type="text" name="country" placeholder="Country"
                                    value="<?php echo $profileData['country'] ?? ''; ?>" required>
                            </div>

                            <div class="section-box">
                                <h3>City/Town</h3>
                                <input type="text" name="city_town" placeholder="City/Town"
                                    value="<?php echo $profileData['city_town'] ?? ''; ?>" required>
                            </div>
                        </div>

                        <div class="section-row">


                            <div class="section-box">
                                <h3>Grade</h3>
                                <input type="number" name="grade" placeholder="Enter your Grade"
                                    value="<?php echo $profileData['student_grade'] ?? ''; ?>" required>
                            </div>
                        </div>

                        <div class="section-row">
                            <button type="submit" class="savechanges-btn">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    
    <script src="js/student/profile.js"></script>
</body>

</html>