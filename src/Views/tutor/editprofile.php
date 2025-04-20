<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/tutor/editprofile.css">
    <link rel="stylesheet" href="css/tutor/sidebar.css">

    <style>
    .profile-picture {
        width: 25%;
        height: auto;
        margin-top: 1%;
        margin-right: 5%;
        margin-left: 15%;
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
<body>

<?php $page="profile"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>

<div class="container">
        <div class="bodyform">
            <!-- Profile Content -->
            <div class="profile-content">
                <!-- Profile Form -->
                <form action="/tutor-profile-updated" method="POST" enctype="multipart/form-data">
                    <div class="viewprofile-header">
                        <div class="profile-picture edit-profile-picture">
                            <img id="profile-image"
                                src="/images/tutor_uploads/tutor_profile_photos/<?php echo isset($profileData['tutor_profile_photo']) ? $profileData['tutor_profile_photo'] : 'profile1.jpg'; ?>"
                                alt="Profile Picture">
                            <label class="edit-change-photo-btn" for="file-input">Change Profile Photo</label>
                            <input type="file" id="file-input" name="profile-image" accept="image/*">
                            <input type="hidden" name="existing_profile_photo" value="<?= $profileData['tutor_profile_photo'] ?? 'profile1.jpg' ?>">
                        </div>
                    
                        <h3>First Name
                            <input type="text" name="tutor_first_name" 
                                value="<?= isset($profileData['tutor_first_name']) ? htmlspecialchars($profileData['tutor_first_name']) : '' ?>" 
                                placeholder="First Name"  />
                            <br>
                            Last Name
                            <input type="text" name="tutor_last_name" 
                                value="<?= isset($profileData['tutor_last_name']) ? htmlspecialchars($profileData['tutor_last_name']) : '' ?>" 
                                placeholder="Last Name" />
                        </h3>

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
                            <div class="section-box">
                                <h3>Specialization</h3>
                                <textarea name="specialization"
                                    placeholder="Enter your specialization details"><?php echo $profileData['specialization'] ?? ''; ?></textarea>
                            </div>
                            <div class="section-box">
                                <h3>Experience</h3>
                                <textarea name="experience"
                                    placeholder="Enter your experience details"><?php echo $profileData['experience'] ?? ''; ?></textarea>
                            </div>
                        </div>
                        <div class="section-row">
                            <div class="section-box">
                                <h3>Contact Information</h3>
                                <input type="text" name="tutor_contact_number" placeholder="Enter phone number"
                                    value="<?php echo $profileData['tutor_contact_number'] ?? ''; ?>">
                                <input type="email" name="tutor_email" placeholder="Enter email"
                                    value="<?php echo $profileData['tutor_email'] ?? ''; ?>">
                            </div>
                            <div class="section-box">
                                <h3>Date of Birth</h3>
                                <input type="date" name="tutor_DOB" 
                                    value="<?php echo $profileData['tutor_DOB'] ?? ''; ?>">
                            </div>
                            <div class="section-box">
                                <h3>NIC No.</h3>
                                <input type="text" name="tutor_NIC" 
                                    value="<?php echo $profileData['tutor_NIC'] ?? ''; ?>">
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
                            <!-- Subjects -->
            <!-- Subjects You Teach -->
            <div class="section-box">
                <h3>Subjects You Teach</h3>
                <?php
                // Map the profileData['subjects'] array to subject IDs (if it's using names)
                $profileSubjectIds = [];
                if (!empty($profileData['subjects'])) {
                    // Assuming profileData['subjects'] contains subject names, we map it to subject IDs
                    $profileSubjectIds = array_map(function ($subjectName) use ($allSubjects) {
                        // Find subject ID by subject name
                        foreach ($allSubjects as $subject) {
                            if ($subject['subject_name'] === $subjectName) {
                                return $subject['subject_id'];
                            }
                        }
                        return null; // Return null if no match found
                    }, $profileData['subjects']);
                }
                ?>

                <?php foreach ($allSubjects as $subject): ?>
                    <label>
                        <input type="checkbox" name="subjects[]" value="<?= $subject['subject_id'] ?>"
                            <?= in_array($subject['subject_id'], $profileSubjectIds) ? 'checked' : '' ?>>
                        <?= htmlspecialchars($subject['subject_name']) ?>
                    </label><br>
                <?php endforeach; ?>
            </div>

            <!-- JavaScript to print both arrays to the console -->
            <!--<script>
                window.addEventListener('DOMContentLoaded', () => {
                    // Convert PHP arrays to JavaScript arrays
                    const profileSubjects = <?= json_encode($profileSubjectIds ?? []) ?>;
                    const allSubjects = <?= json_encode($allSubjects) ?>;

                    // Log both arrays to the console
                    console.log("Profile Subject IDs:", profileSubjects);
                    console.log("All Subjects:", allSubjects);

                    // Function to log checked subject IDs
                    const checkboxes = document.querySelectorAll('input[name="subjects[]"]');
                    function logCheckedSubjects() {
                        const checkedSubjects = [];
                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                checkedSubjects.push(checkbox.value);
                            }
                        });
                        console.log("Checked subject IDs:", checkedSubjects);
                    }

                    // Initially log checked subjects on page load
                    logCheckedSubjects();

                    // Add event listener to log when checkboxes are changed
                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener('change', logCheckedSubjects);
                    });
                });
            </script>-->







                            <!-- Grades -->
                            <div class="section-box">
                                <h3>Grades You Teach</h3>
                                <?php for ($grade = 6; $grade <= 11; $grade++): ?>
                                    <label>
                                        <input type="checkbox" name="grades[]" value="<?= $grade ?>"
                                            <?= in_array($grade, $profileData['grades'] ?? []) ? 'checked' : '' ?>>
                                        Grade <?= $grade ?>
                                    </label><br>
                                <?php endfor; ?>
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