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
            <form action="/admin-update-student-profile/<?= htmlspecialchars($student['student_id'] ?? '') ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">

                <div class="viewprofile-content">
                    <div class="viewprofile-header">
                        <div class="profile-photo-container">
                            <?php if (!empty($student['student_profile_photo'])): ?>
                                <img src="\images\student-uploads\profilePhotos\<?php echo htmlspecialchars($student['student_profile_photo']); ?>" class="viewprofile-img" alt="Profile Photo">
                            <?php else: ?>
                                <img src="\images\student-uploads\profilePhotos\default-profile.jpg" class="viewprofile-img" alt="Default Profile Photo">
                            <?php endif; ?>
                        </div>
                        <div class="profile-info">
                            <h1>
                                <?php echo htmlspecialchars($student['student_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($student['student_last_name'] ?? 'Last Name'); ?>
                            </h1>
                            <?php if (isset($_GET['success'])): ?>
                                <div class="success-message">Profile updated successfully!</div>
                            <?php elseif (isset($_GET['error'])): ?>
                                <div class="error-message">Failed to update profile. Please try again.</div>
                            <?php elseif (isset($_GET['email_exists'])): ?>
                                <div class="error-message">Email already exists. Please use a different email.</div>
                            <?php endif; ?>
                            <div class="button-group">
                                <button type="submit" class="edit-button">Save Changes</button>
                                <a href="/admin-student-profile/<?= htmlspecialchars($student['student_id'] ?? '') ?>" class="edit-button">Cancel</a>
                                <?php if ($student['student_status'] === 'blocked'): ?>
                                    <form action="/admin-unblock-student/<?= htmlspecialchars($student['student_id'] ?? '') ?>" method="POST" style="display:inline;">
                                        <button type="submit" class="edit-button unblock-button" onclick="return confirm('Are you sure you want to unblock this student?');">Unblock Student</button>
                                    </form>
                                <?php elseif ($student['student_status'] === 'set'): ?>
                                    <form action="/admin-block-student/<?= htmlspecialchars($student['student_id'] ?? '') ?>" method="POST" style="display:inline;">
                                        <button type="submit" class="edit-button block-button" onclick="return confirm('Are you sure you want to block this student?');">Block Student</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="viewprofile-details">
                        <div class="detail-item">
                            <strong>First Name:</strong>
                            <span class="detail-value">
                                <input type="text" id="firstname" name="student_first_name" value="<?= htmlspecialchars($student['student_first_name'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Last Name:</strong>
                            <span class="detail-value">
                                <input type="text" id="lastname" name="student_last_name" value="<?= htmlspecialchars($student['student_last_name'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Email:</strong>
                            <span class="detail-value">
                                <input type="email" id="email" name="student_email" value="<?= htmlspecialchars($student['student_email'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Phone</strong>
                            <span class="detail-value">
                                <input type="tel" id="phonenumber" name="student_phonenumber" value="<?= htmlspecialchars($student['student_phonenumber'] ?? '') ?>" pattern="[0-9]{10}" maxlength="10" oninput="validatePhone(this)">
                                <span id="phoneError" class="error-message" style="color:red; display:none;">Phone number must be 10 digits</span>
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
                                <input type="number" id="grade" name="student_grade" value="<?= htmlspecialchars($student['student_grade'] ?? '') ?>" min="6" max="13" oninput="validateGrade(this)">
                                <span id="gradeError" class="error-message" style="color:red; display:none;">Grade must be between 6 and 13</span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Profile Photo:</strong>
                            <span class="detail-value">
                                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
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

<script>
function validateGrade(input) {
    const gradeError = document.getElementById('gradeError');
    const value = parseInt(input.value);
    
    if (isNaN(value) || value < 6 || value > 13) {
        gradeError.style.display = 'inline';
        return false;
    } else {
        gradeError.style.display = 'none';
        return true;
    }
}

function validatePhone(input) {
    const phoneError = document.getElementById('phoneError');
    const value = input.value;
    
    if (!/^\d{10}$/.test(value)) {
        phoneError.style.display = 'inline';
        return false;
    } else {
        phoneError.style.display = 'none';
        return true;
    }
}

function validateForm() {
    const gradeValid = validateGrade(document.getElementById('grade'));
    const phoneValid = validatePhone(document.getElementById('phonenumber'));
    
    if (!gradeValid) {
        alert('Please enter a valid grade between 6 and 13');
        return false;
    }
    if (!phoneValid) {
        alert('Please enter a valid 10-digit phone number');
        return false;
    }
    return confirm('Are you sure you want to update this profile?');
}
</script>
</html>
