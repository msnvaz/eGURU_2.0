<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminStudentProfile.css">
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
                        src="../uploads/Student_Profiles/<?php echo htmlspecialchars($student['student_profile_photo']); ?>" 
                        class="viewprofile-img"
                        alt="Profile Photo"
                    >
                </div>
                <div class="profile-info">
                    <h1>
                        <?php 
                        echo htmlspecialchars($student['student_first_name'] ?? 'First Name') . ' ' . 
                             htmlspecialchars($student['student_last_name'] ?? 'Last Name'); 
                        ?>
                    </h1>
                    <?php if (isset($_GET['success'])): ?>
                        <div class="success-message">Profile updated successfully!</div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'duplicate_email'): ?>
                        <div class="error-message">Email already exists. Please use a different email.</div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'invalid_age'): ?>
                        <div class="error-message">Student must be at least 6 years old.</div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'delete_success'): ?>
                        <div class="success-message">Profile deleted successfully!</div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 'delete_failed'): ?>
                        <div class="error-message">Failed to delete profile. Please try again.</div>
                    <?php elseif (isset($_GET['error'])): ?>
                        <div class="error-message">Operation failed. Please try again.</div>
                    <?php endif; ?>
                    
                    <div class="button-group">
                        <a href="/admin-edit-student-profile/<?= htmlspecialchars($student['student_id'] ?? '') ?>" class="edit-button">Edit Profile</a>             
                        <?php if ($student['student_status'] === 'unset'): ?>
                            <form action="/admin-restore-student/<?= htmlspecialchars($student['student_id'])?>" method="POST" onsubmit="return confirmRestore()">
                                <button type="submit" class="edit-button">Restore Profile</button>
                            </form>
                        <?php else: ?>
                            <form action="/student-delete-profile/<?= htmlspecialchars($student['student_id'])?>" method="POST" onsubmit="return confirmDelete()">
                                <button type="submit" class="edit-button">Delete Profile</button>
                            </form>
                        <?php endif; ?>
                        <script>
                            function confirmRestore() {
                                return confirm('Are you sure you want to restore this student profile?');
                            }
                            function confirmDelete() {

                                return confirm('Are you sure you want to delete this student profile?');
                            }
                        </script>                    
                    </div>
                </div>
            </div>

            <div class="viewprofile-details">
                <div class="detail-item">
                    <strong>Email:</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['student_email'] ?? 'Email not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Phone</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['student_phonenumber'] ?? 'Phone not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Date of Birth</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['student_DOB'] ?? 'DOB not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Registration Date</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['student_registration_date'] ?? ' not available'); ?>
                    </span>
                </div>

                <div class="detail-item">
                    <strong>Grade</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['student_grade'] ?? ' not available'); ?>
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
                        <?php echo htmlspecialchars($student['student_points'] ?? ' not available'); ?>
                    </span>
                </div>

                <!--last login-->
                <div class="detail-item">
                    <strong>Last Login</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['student_last_login'] ?? ' not available'); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
