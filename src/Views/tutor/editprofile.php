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

          
           .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.59); /* dark background */
        }

        
        .modal-content {
            border-top: 6px solid #e03570;
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
            align-items: center;
        }

        
        .close {
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 24px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        
        .modal-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .confirm-button {
            background-color: #ff4081;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-button:hover {
            background-color: #e03570;
        }

        .modal-cancel-button {
            background-color: #ddd;
            color: #333;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-cancel-button:hover {
            background-color: #bbb;
        }

    </style>
</head>
<body>

<?php $page="profile"; ?>


<?php include 'sidebar.php'; ?>


<?php include '../src/Views/tutor/header.php'; ?>

<?php
$successMessage = isset($_GET['success']) && !empty($_GET['success']) ? $_GET['success'] : null;
$errorMessage = isset($_GET['error']) && !empty($_GET['error']) ? $_GET['error'] : null;
?>

<?php if ($successMessage || $errorMessage): ?>
    <div id="messageModal" class="modal" style="display: block;">
        <div class="modal-content">
            <span class="close" onclick="closeMessageModal()">&times;</span>
            <h2><?= $successMessage ? 'Success' : 'Error' ?></h2>
            <hr style="color:#adb5bd;">
            <br>
            <p style="text-align:center; color: <?= $successMessage ? 'black' : 'red' ?>;">
                <?= htmlspecialchars($successMessage ?? $errorMessage) ?>
            </p>
            <div class="modal-actions" >
                <button style="margin-left:43%;" class="confirm-button" onclick="closeMessageModal()">OK</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
        const url = new URL(window.location);
        url.searchParams.delete('success');
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url);
    }
</script>


<div class="container">
        <div class="bodyform">
            
            <div class="profile-content">
                
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
                                placeholder="First Name" readonly />
                            <br>
                            Last Name
                            <input type="text" name="tutor_last_name" 
                                value="<?= isset($profileData['tutor_last_name']) ? htmlspecialchars($profileData['tutor_last_name']) : '' ?>" 
                                placeholder="Last Name" readonly />
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
                                    value="<?php echo $profileData['tutor_contact_number'] ?? ''; ?>" readonly>
                                <input type="email" name="tutor_email" placeholder="Enter email"
                                    value="<?php echo $profileData['tutor_email'] ?? ''; ?>" readonly>
                            </div>
                            <div class="section-box">
                                <h3>Date of Birth</h3>
                                <input type="date" name="tutor_DOB" 
                                    value="<?php echo $profileData['tutor_DOB'] ?? ''; ?>" readonly>
                            </div>
                            <div class="section-box">
                                <h3>NIC No.</h3>
                                <input type="text" name="tutor_NIC" 
                                    value="<?php echo $profileData['tutor_NIC'] ?? ''; ?>" readonly>
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
                <h3>Subjects You Teach</h3>
                <?php
                
                $profileSubjectIds = [];
                if (!empty($profileData['subjects'])) {
                    
                    $profileSubjectIds = array_map(function ($subjectName) use ($allSubjects) {
                        
                        foreach ($allSubjects as $subject) {
                            if ($subject['subject_name'] === $subjectName) {
                                return $subject['subject_id'];
                            }
                        }
                        return null; 
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