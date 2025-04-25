<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminTutorProfile.css">
    <style>
        .success-message {
            color: green;
            margin-bottom: 15px;
            font-weight: bold;
            padding-left: 20px;
        }
        .error-message {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    <div class="main">
    <div class="profile-bodyform">
        <div class="viewprofile-content">
            <div class="viewprofile-header">
                <div class="profile-photo-container">
                    <img 
                        src="\images\tutor_uploads\tutor_profile_photos\<?php echo htmlspecialchars($tutor['tutor_profile_photo'] ?? 'default.jpg'); ?>" 
                        class="viewprofile-img"
                        alt="Profile Photo"
                    >
                </div>
                <div class="profile-info">
                    <h1>
                        <?php 
                        echo htmlspecialchars($tutor['tutor_first_name'] ?? 'First Name') . ' ' . 
                             htmlspecialchars($tutor['tutor_last_name'] ?? 'Last Name'); 
                        ?>
                    </h1>
                    <?php if (isset($_GET['success'])): ?>
                        <div class="success-message">Profile updated successfully!</div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'duplicate_email'): ?>
                        <div class="error-message">Email already exists. Please use a different email.</div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'delete_success'): ?>
                        <div class="success-message">Profile deleted successfully!</div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'delete_failed'): ?>
                        <div class="error-message">Failed to delete profile. Please try again.</div>
                    <?php elseif (isset($_GET['error'])): ?>
                        <div class="error-message">Operation failed. Please try again.</div>
                    <?php endif; ?>
                    
                    <div class="button-group">
                        <a href="/admin-edit-tutor-profile/<?= htmlspecialchars($tutor['tutor_id'] ?? '') ?>" class="edit-button">Edit Profile</a>             
                        <?php if ($tutor['tutor_status'] === 'unset'): ?>
                            <form action="/admin-restore-tutor/<?= htmlspecialchars($tutor['tutor_id'])?>" method="POST" onsubmit="return confirmRestore()">
                                <button type="submit" class="edit-button">Restore Profile</button>
                            </form>
                        <?php elseif ($tutor['tutor_status'] === 'blocked'): ?>
                            <form action="/admin-unblock-tutor/<?= htmlspecialchars($tutor['tutor_id'])?>" method="POST" onsubmit="return confirmUnblock()">
                                <button type="submit" class="edit-button">Unblock Profile</button>
                            </form>
                        <?php else: ?>
                            <form action="/admin-block-tutor/<?= htmlspecialchars($tutor['tutor_id'])?>" method="POST" onsubmit="return confirmBlock()">
                                <button type="submit" class="edit-button">Block Profile</button>
                            </form>
                            <form action="/tutor-delete-profile/<?= htmlspecialchars($tutor['tutor_id'])?>" method="POST" onsubmit="return confirmDelete()">
                                <button type="submit" class="edit-button">Delete Profile</button>
                            </form>
                        <?php endif; ?>
                        <script>
                            function confirmRestore() {
                                return confirm('Are you sure you want to restore this tutor profile?');
                            }
                            function confirmDelete() {
                                return confirm('Are you sure you want to delete this tutor profile?');
                            }
                            function confirmBlock() {
                                return confirm('Are you sure you want to block this tutor profile?');
                            }
                            function confirmUnblock() {
                                return confirm('Are you sure you want to unblock this tutor profile?');
                            }
                        </script>                    
                    </div>
                </div>
            </div>

            <div class="viewprofile-details">
                <div class="detail-item">
                    <strong>Email:</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($tutor['tutor_email'] ?? 'Email not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Phone</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($tutor['tutor_contact_number'] ?? 'Phone not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Date of Birth</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($tutor['tutor_DOB'] ?? 'DOB not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Registration Date</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($tutor['tutor_registration_date'] ?? ' not available'); ?>
                    </span>
                </div>

                <div class="detail-item">
                    <strong>Grade Level</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($tutor['tutor_level_id'] ?? ' not available'); ?>
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
                        <?php echo htmlspecialchars($tutor['tutor_points'] ?? ' not available'); ?>
                    </span>
                </div>

                <div class="detail-item">
                    <strong>Last Login</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($tutor['tutor_last_login'] ?? ' not available'); ?>
                    </span>
                </div>
                
                <!-- Modify the account status section -->
                <div class="detail-item">
                    <strong>Account Status</strong>
                    <span class="detail-value">
                        <?php 
                        $status = $tutor['tutor_status'] ?? '';
                        if ($status === 'set') {
                            echo 'Active';
                        } elseif ($status === 'unset') {
                            echo 'Deleted';
                        } elseif ($status === 'blocked') {
                            echo '<span style="color: #d9534f; font-weight: bold;">Blocked</span>';
                        } elseif ($status === 'requested') {
                            echo '<span style="color: #ffc107; font-weight: bold;">Pending Approval</span>';
                        } else {
                            echo htmlspecialchars($status);
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="viewprofile-sections">
                    <!-- Tutor Advertisements Section -->
                    <div class="section-container">
                        <h3>Advertisements</h3>
                        <?php if (empty($advertisements)): ?>
                            <p>No advertisements found for this tutor.</p>
                        <?php else: ?>
                            <div class="ad-grid">
                                <?php foreach ($advertisements as $ad): ?>
                                    <div class="ad-card">
                                        <div class="ad-image">
                                            <?php if (!empty($ad['ad_display_pic'])): ?>
                                                <img src="/uploads/tutor_ads/<?= htmlspecialchars($ad['ad_display_pic']); ?>" alt="Advertisement">
                                            <?php else: ?>
                                                <div class="no-image">No Image</div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ad-details">
                                            <p class="ad-description"><?= htmlspecialchars($ad['ad_description']); ?></p>
                                            <div class="ad-meta">
                                                <span class="ad-date">Posted: <?= date('M d, Y', strtotime($ad['ad_created_at'])); ?></span>
                                                <span class="ad-status <?= $ad['ad_status'] === 'set' ? 'active' : 'inactive'; ?>">
                                                    Status: <?= $ad['ad_status'] === 'set' ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Tutor Study Materials Section -->
                    <div class="section-container">
                        <h3>Study Materials</h3>
                        <?php if (empty($studyMaterials)): ?>
                            <p>No study materials found for this tutor.</p>
                        <?php else: ?>
                            <div class="materials-table-container">
                                <table class="materials-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Subject</th>
                                            <th>Description</th>
                                            <th>Grade</th>
                                            <th>Status</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($studyMaterials as $material): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($material['material_id']); ?></td>
                                                <td><?= htmlspecialchars($material['subject_name'] ?? 'N/A'); ?></td>
                                                <td><?= htmlspecialchars($material['material_description']); ?></td>
                                                <td><?= htmlspecialchars($material['grade']); ?></td>
                                                <td>
                                                    <span class="status-badge <?= $material['material_status'] === 'set' ? 'active' : 'inactive'; ?>">
                                                        <?= $material['material_status'] === 'set' ? 'Active' : 'Inactive'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if (!empty($material['material_path'])): ?>
                                                        <a href="/download-material/<?= htmlspecialchars($material['material_id']); ?>" class="download-button">
                                                            Download
                                                        </a>
                                                    <?php else: ?>
                                                        <span>No file</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($tutor['tutor_status'] === 'requested' && !empty($tutor['tutor_qualification_proof'])): ?>
                <div class="detail-item">
                    <strong>Qualification Proof</strong>
                    <span class="detail-value">
                        <a href="/download-qualification-proof/<?= htmlspecialchars($tutor['tutor_id']); ?>" class="edit-button">
                            <i class="fas fa-download"></i> Download Proof
                        </a>
                    </span>
                </div>
                <?php endif; ?>
    </div>
    </div>
    
</body>
</html>