<?php // Get tutor data from controller
$tutor = $tutorData ?? [];
$advertisements = $tutorAdvertisements ?? [];
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
    <style>
        /* Advertisement styling */
        .ads-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
            background-color: #f9f9f900;
        }
        
        .ad-card1 {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }
        
        .ad-card1:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
        }
        
        .ad-image {
            height: 180px;
            background-color: #eaeef2;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .ad-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .no-image {
            color: #8a94a6;
            font-size: 14px;
            text-align: center;
        }
        
        .ad-details {
            padding: 16px;
        }
        
        .ad-description {
            margin: 0 0 16px 0;
            font-size: 15px;
            color: #333;
            line-height: 1.5;
        }
        
        .ad-description textarea {
            width: 100%;
            min-height: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px;
            font-family: inherit;
            resize: vertical;
        }
        
        .ad-meta {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #7a8599;
        }
        
        .ad-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .ad-controls {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        
        .ad-controls button {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        
        .save-btn {
            background-color: #4CAF50;
            color: white;
        }
        
        .save-btn:hover {
            background-color: #45a049;
        }
        
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        
        .delete-btn:hover {
            background-color: #d32f2f;
        }
        
        .image-upload {
            margin-top: 10px;
        }
        
        .image-upload input {
            width: 100%;
        }
        
        .section-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f900;
            border-radius: 8px;
            width:70%;margin-left:15%;
        }
        
        .section-container h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #333;
            background-color: #f9f9f900;
        }
    </style>
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
                                <img src="\images\tutor_uploads\tutor_profile_photos\<?php echo htmlspecialchars($tutor['tutor_profile_photo']); ?>" class="viewprofile-img" alt="Profile Photo">
                            <?php else: ?>
                                <img src="\images\tutor_uploads\tutor_profile_photos\default.jpg" class="viewprofile-img" alt="Default Profile Photo">
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
                                <button type="submit" class="edit-button">Save Profile Changes</button>
                                <a href="/admin-tutor-profile/<?= htmlspecialchars($tutor['tutor_id'] ?? '') ?>" class="edit-button">Cancel</a>
                            </div>
                        </div>
                    </div>

                    <div class="viewprofile-details">
                        <!-- Original profile edit fields -->
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

            <!-- Advertisements Section -->
            <div class="section-container">
                <h3>Edit Advertisements</h3>
                <?php if (empty($advertisements)): ?>
                    <p>No advertisements found for this tutor.</p>
                <?php else: ?>
                    <div class="ads-container">
                        <?php foreach ($advertisements as $ad): ?>
                            <div class="ad-card1">
                                <form action="/admin-update-advertisement/<?= htmlspecialchars($ad['ad_id']); ?>" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="tutor_id" value="<?= htmlspecialchars($tutor['tutor_id']); ?>">
                                    <div class="ad-image">
                                        <?php if (!empty($ad['ad_display_pic'])): ?>
                                            <img src="/uploads/tutor_ads/<?= htmlspecialchars($ad['ad_display_pic']); ?>" alt="Advertisement">
                                        <?php else: ?>
                                            <div class="no-image">No Image Available</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ad-details" >
                                        <div class="ad-description">
                                            <textarea name="ad_description" placeholder="Advertisement description"><?= htmlspecialchars($ad['ad_description']); ?></textarea>
                                        </div>
                                        <div class="image-upload" style="margin-top: 10px;">
                                            <label for="ad_image_<?= $ad['ad_id']; ?>">Update Image:</label>
                                            <input type="file" id="ad_image_<?= $ad['ad_id']; ?>" name="ad_image" accept="image/*">
                                        </div>
                                        <div class="ad-meta" style="margin-top: 10px;">
                                            <span class="ad-date"><?= date('M d, Y', strtotime($ad['ad_created_at'])); ?></span>
                                            <select name="ad_status" style="width: 50%;">
                                                <option value="set" <?= $ad['ad_status'] === 'set' ? 'selected' : ''; ?>>Active</option>
                                                <option value="unset" <?= $ad['ad_status'] === 'unset' ? 'selected' : ''; ?>>Inactive</option>
                                            </select>
                                        </div>
                                        <div class="ad-controls" style="margin-top: 10px;">
                                            <button type="submit" class="btn btn-warning refund-button" style="background-color: var(--dark-pink);"
                                            >Save Changes</button>
                                            <button type="button" class="btn btn-warning refund-button" style="background-color: #f44336;" 
                                            onclick="confirmAdDelete(<?= $ad['ad_id']; ?>)">Delete</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Add New Advertisement -->
                <div style="margin-top: 20px; background-color: #f0f8ff00;">
                    <h3>Add New Advertisement</h3>
                    <form action="/admin-add-advertisement" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="tutor_id" value="<?= htmlspecialchars($tutor['tutor_id']); ?>">
                        <div class="detail-item">
                            <strong>Description:</strong>
                            <span class="detail-value">
                                <textarea name="ad_description" placeholder="Enter advertisement description" required style="width: 100%; min-height: 100px;"></textarea>
                            </span>
                        </div>
                        <div class="detail-item">
                            <strong>Image:</strong>
                            <span class="detail-value">
                                <input type="file" name="ad_image" accept="image/*" required>
                            </span>
                        </div>
                        <div class="button-group" style="margin-top: 15px;">
                            <button type="submit" class="edit-button">Add Advertisement</button>
                        </div>
                    </form>
                </div>
            </div>
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

    // Validate age is at least 18 years
    const dobInput = document.getElementById('dateofbirth').value;
    if (dobInput) {
        const dob = new Date(dobInput);
        const today = new Date();
        const ageDiff = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        if (ageDiff < 18 || (ageDiff === 18 && m < 0) || (ageDiff === 18 && m === 0 && today.getDate() < dob.getDate())) {
            alert('Tutor must be at least 18 years old.');
            return false;
        }
    }

    if (!phoneValid) {
        alert('Please enter a valid 10-digit phone number');
        return false;
    }
    return confirm('Are you sure you want to update this profile?');
}

function confirmAdDelete(adId) {
    if (confirm('Are you sure you want to delete this advertisement?')) {
        window.location.href = `/admin-delete-advertisement/${adId}?tutor_id=<?= htmlspecialchars($tutor['tutor_id'] ?? ''); ?>`;
    }
}
</script>
</html>