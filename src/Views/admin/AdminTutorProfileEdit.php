<?php // Get tutor data from controller
$tutor = $tutorData ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tutor Profile - eGURU Admin</title>
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminStudentProfile.css">
</head>

<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>

    <div class="main">
        <div class="profile-bodyform">
            <form action="/admin-update-tutor-profile/<?= htmlspecialchars($tutor['tutor_id'] ?? '') ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">

                <div class="viewprofile-content">
                    <div class="viewprofile-header">
                        <div class="profile-photo-container">
                            <?php if (!empty($tutor['tutor_profile_photo'])): ?>
                                <img src="/uploads/Tutor_Profiles/<?php echo htmlspecialchars($tutor['tutor_profile_photo']); ?>" class="viewprofile-img" alt="Profile Photo">
                            <?php else: ?>
                                <img src="/uploads/Tutor_Profiles/default.jpg" class="viewprofile-img" alt="Default Profile Photo">
                            <?php endif; ?>
                        </div>
                        <div class="profile-info">
                            <h1>
                                <?php echo htmlspecialchars($tutor['tutor_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($tutor['tutor_last_name'] ?? 'Last Name'); ?>
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
                                <a href="/admin-tutor-profile/<?= htmlspecialchars($tutor['tutor_id'] ?? '') ?>" class="edit-button">Cancel</a>
                            </div>
                        </div>
                    </div>

                    <div class="viewprofile-details">
                        <div class="detail-item">
                            <strong>First Name:</strong>
                            <span class="detail-value">
                                <input type="text" id="firstname" name="tutor_first_name" value="<?= htmlspecialchars($tutor['tutor_first_name'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Last Name:</strong>
                            <span class="detail-value">
                                <input type="text" id="lastname" name="tutor_last_name" value="<?= htmlspecialchars($tutor['tutor_last_name'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Email:</strong>
                            <span class="detail-value">
                                <input type="email" id="email" name="tutor_email" value="<?= htmlspecialchars($tutor['tutor_email'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Phone</strong>
                            <span class="detail-value">
                                <input type="tel" id="phonenumber" name="tutor_contact_number" value="<?= htmlspecialchars($tutor['tutor_contact_number'] ?? '') ?>" pattern="[0-9]{10}" maxlength="10" oninput="validatePhone(this)">
                                <span id="phoneError" class="error-message" style="color:red; display:none;">Phone number must be 10 digits</span>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Date of Birth</strong>
                            <span class="detail-value">
                                <input type="date" id="dateofbirth" name="tutor_DOB" value="<?= htmlspecialchars($tutor['tutor_DOB'] ?? '') ?>">
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Grade Level</strong>
                            <span class="detail-value">
                                <select id="grade" name="tutor_level_id">
                                    <option value="G01" <?= ($tutor['tutor_level_id'] ?? '') == 'G01' ? 'selected' : '' ?>>Grade 1</option>
                                    <option value="G02" <?= ($tutor['tutor_level_id'] ?? '') == 'G02' ? 'selected' : '' ?>>Grade 2</option>
                                    <option value="G03" <?= ($tutor['tutor_level_id'] ?? '') == 'G03' ? 'selected' : '' ?>>Grade 3</option>
                                    <option value="G04" <?= ($tutor['tutor_level_id'] ?? '') == 'G04' ? 'selected' : '' ?>>Grade 4</option>
                                    <option value="G05" <?= ($tutor['tutor_level_id'] ?? '') == 'G05' ? 'selected' : '' ?>>Grade 5</option>
                                    <option value="G06" <?= ($tutor['tutor_level_id'] ?? '') == 'G06' ? 'selected' : '' ?>>Grade 6</option>
                                </select>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Profile Photo:</strong>
                            <span class="detail-value">
                                <input type="file" id="profile_photo" name="profile_photo" accept="image/*">
                                <?php if (!empty($tutor['tutor_profile_photo'])): ?>
                                    <p>Current Photo: <?= htmlspecialchars($tutor['tutor_profile_photo']) ?></p>
                                <?php endif; ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Tutor ID</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($tutor['tutor_id'] ?? 'not available'); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Wallet Points</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($tutor['tutor_points'] ?? 'not available'); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Last Login</strong>
                            <span class="detail-value">
                                <?php echo htmlspecialchars($tutor['tutor_last_login'] ?? 'not available'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

<script>
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
    const phoneValid = validatePhone(document.getElementById('phonenumber'));
    
    if (!phoneValid) {
        alert('Please enter a valid 10-digit phone number');
        return false;
    }
    return confirm('Are you sure you want to update this profile?');
}
</script>
</html>