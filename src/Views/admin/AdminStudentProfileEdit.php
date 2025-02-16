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
            <form action="/admin-update-student-profile/<?= htmlspecialchars($student['id'] ?? '') ?>" method="POST" enctype="multipart/form-data">
                <div class="viewprofile-content">
                    <div class="viewprofile-header">
                        <div class="profile-photo-container">
                            <img src="../uploads/Student_Profiles/<?php echo htmlspecialchars($student['profile_photo']); ?>" class="viewprofile-img" alt="Profile Photo">
                        </div>
                        <div class="profile-info">
                            <h1>
                                <?php echo htmlspecialchars($student['firstname'] ?? 'First Name') . ' ' . htmlspecialchars($student['lastname'] ?? 'Last Name'); ?>
                            </h1>
                            <?php if (isset($_GET['success'])): ?>
                                <div class="success-message">Profile updated successfully!</div>
                            <?php elseif (isset($_GET['error'])): ?>
                                <div class="error-message">Failed to update profile. Please try again.</div>
                            <?php endif; ?>
                            <div class="button-group">
                                <button type="submit" class="edit-button">Save Changes</button>
                                <a href="/admin-student-profile/<?= htmlspecialchars($student['id'] ?? '') ?>" class="edit-button">Cancel</a>
                            </div>
                        </div>
                    </div>

                    <div class="viewprofile-details">
                        <div class="detail-item">
                            <strong>First Name:</strong>
                            <span class="detail-value">
                                <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($student['firstname'] ?? '') ?>">
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Last Name:</strong>
                            <span class="detail-value">
                                <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($student['lastname'] ?? '') ?>">
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Email:</strong>
                            <span class="detail-value">
                                <input type="email" id="email" name="email" value="<?= htmlspecialchars($student['email'] ?? '') ?>">
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Phone</strong>
                            <span class="detail-value">
                                <input type="tel" id="phonenumber" name="phonenumber" value="<?= htmlspecialchars($student['phonenumber'] ?? '') ?>">
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Date of Birth</strong>
                            <span class="detail-value">
                                <input type="date" id="dateofbirth" name="dateofbirth" value="<?= htmlspecialchars($student['dateofbirth'] ?? '') ?>">
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Grade</strong>
                            <span class="detail-value">
                                <input type="text" id="grade" name="grade" value="<?= htmlspecialchars($student['grade'] ?? '') ?>">
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Profile Photo:</strong>
                            <span class="detail-value">
                                <input type="file" id="profile_photo" name="profile_photo">
                                <?php if (!empty($student['profile_photo'])): ?>
                                    <p>Current Photo: <?= htmlspecialchars($student['profile_photo']) ?></p>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Student ID</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($student['id'] ?? 'not available'); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Wallet Points</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($student['points'] ?? 'not available'); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Last Login</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($student['last_login'] ?? 'not available'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
