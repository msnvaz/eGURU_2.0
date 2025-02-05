<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/student/profile.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">

    <style>
    .profile-picture {
        width: 25%;
        height: auto;
        margin-top: 1%;
        margin-right: 5%;
    }

    .profile-picture img {
        height: 15rem;
        width: auto;
        border-radius: 10%;
    }

    .edit-profile-picture {
        position: relative;
        overflow: hidden;
        width: 25%
    }

    .edit-profile-picture img {
        object-fit: cover;
        width: 75%;
    }

    .edit-change-photo-btn {
        width: 75%;
        display: block;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        text-align: center;
        padding: 10px;
        font-size: 14px;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s;
    }

    .edit-profile-picture:hover .edit-change-photo-btn {
        opacity: 1;
    }

    .edit-profile-picture #file-input {
        display: none;
    }
    </style>
</head>
<?php $page="profile"; ?>

<body>
    <?php include '../src/Views/navbar.php'; ?>
    <!-- header part here -->
    <div class="container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <div class="bodyform">
            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Profile Form -->
                <form action="/student-profile-updated" method="POST" enctype="multipart/form-data">
                    <div class="profile-picture edit-profile-picture">
                        <img id="profile-image"
                            src="images/student-uploads/profilePhotos/<?= $profileData['profile_picture']?>"
                            alt="Profile Picture">
                        <label class="edit-change-photo-btn" for="file-input">Change Profile Photo</label>
                        <input type="file" id="file-input" name="profile-image" accept="image/*">
                                  
                    </div>


                    <div class="profile-section">
                        <div class="section-row">
                            <div class="section-box">
                                <h3>Bio</h3>
                                <textarea name="bio"
                                    placeholder="Enter your bio"><?php echo $profileData['bio']; ?></textarea>
                            </div>
                            <div class="section-box">
                                <h3>Education</h3>
                                <textarea name="education"
                                    placeholder="Enter your education details"><?php echo $profileData['education']; ?></textarea>
                            </div>
                        </div>
                        <div class="section-row">
                            <div class="section-box">
                                <h3>Contact Information</h3>
                                <input type="text" name="phone" placeholder="Enter phone number"
                                    value="<?php echo $profileData['phone']; ?>">
                                <input type="email" name="email" placeholder="Enter email"
                                    value="<?php echo $profileData['email']; ?>">
                            </div>
                            <div class="section-box">
                                <h3>Interests</h3>
                                <textarea name="interests"
                                    placeholder="Enter your interests"><?php echo $profileData['interests']; ?></textarea>
                            </div>
                        </div>

                        <div class="section-row">
                            <div class="section-box">
                                <h3>Country</h3>
                                <input type="text" name="country" placeholder="Country"
                                    value="<?php echo $profileData['country']; ?>" required>
                            </div>

                            <div class="section-box">
                                <h3>City/Town</h3>
                                <input type="text" name="city_town" placeholder="City/Town"
                                    value="<?php echo $profileData['city_town']; ?>" required>
                            </div>
                        </div>

                        <div class="section-row">


                            <div class="section-box">
                                <h3>Grade</h3>
                                <input type="number" name="grade" placeholder="Enter your Grade"
                                    value="<?php echo $profileData['grade']; ?>" required>
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
    <script src="profile.js"></script>
    <script>
    document.getElementById('file-input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const profileImage = document.getElementById('profile-image');
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>

</html>