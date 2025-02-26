<?php // Get student data from controller
$student = $studentData ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Profile - eGURU Admin</title>
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminStudentProfile.css">
</head>

<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>

    <div class="main">
        <div class="profile-bodyform">
            <form action="/admin-update-student-profile/<?= htmlspecialchars($student['student_id'] ?? '') ?>" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to update this profile?');">

                <div class="viewprofile-content">
                    <div class="viewprofile-header">
                        <div class="profile-photo-container">
                            <img src="../uploads/Student_Profiles/<?php echo htmlspecialchars($student['student_profile_photo']); ?>" class="viewprofile-img" alt="Profile Photo">
                        </div>
                        <div class="profile-info">
                            <h1>
                                <?php echo htmlspecialchars($student['student_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($student['student_last_name'] ?? 'Last Name'); ?>
                            </h1>
                            <?php if (isset($_GET['success'])): ?>
                                <div class="success-message">Profile updated successfully!</div>
                            <?php elseif (isset($_GET['error'])): ?>
                                <div class="error-message">Failed to update profile. Please try again.</div>
                            <?php endif; ?>
                            <div class="button-group">
                                <button type="submit" class="edit-button">Save Changes</button>
                                <a href="/admin-student-profile/<?= htmlspecialchars($student['student_id'] ?? '') ?>" class="edit-button">Cancel</a>
                            </div>
                        </div>
                    </div>

                    <div class="viewprofile-details">
                        <div class="detail-item">
                            <strong>First Name:</strong>
                            <span class="detail-value">
                                <input type="text" id="firstname" name="student_first_name" value="<?= htmlspecialchars($student['student_first_name'] ?? '') ?>">

                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Last Name:</strong>
                            <span class="detail-value">
                                <input type="text" id="lastname" name="student_last_name" value="<?= htmlspecialchars($student['student_last_name'] ?? '') ?>">

                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Email:</strong>
                            <span class="detail-value">
                                <input type="email" id="email" name="student_email" value="<?= htmlspecialchars($student['student_email'] ?? '') ?>">

                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Phone</strong>
                            <span class="detail-value">
                                <input type="tel" id="phonenumber" name="student_phonenumber" value="<?= htmlspecialchars($student['student_phonenumber'] ?? '') ?>">

                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Date of Birth</strong>
                            <span class="detail-value">
                                <input type="date" id="dateofbirth" name="student_DOB" value="<?= htmlspecialchars($student['student_DOB'] ?? '') ?>">

                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Grade</strong>
                            <span class="detail-value">
                                <input type="text" id="grade" name="student_grade" value="<?= htmlspecialchars($student['student_grade'] ?? '') ?>">

                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Profile Photo:</strong>
                            <span class="detail-value">
                                <input type="file" id="profile_photo" name="profile_photo">
                                <?php if (!empty($student['student_profile_photo'])): ?>
                                    <p>Current Photo: <?= htmlspecialchars($student['student_profile_photo']) ?></p>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Student ID</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($student['student_id'] ?? 'not available'); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Wallet Points</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($student['student_points'] ?? 'not available'); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Last Login</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($student['student_last_login'] ?? 'not available'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
