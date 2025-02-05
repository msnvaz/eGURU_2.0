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
        /* Global Styles */
        
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
                        src="../uploads/Student_Profiles/<?php echo htmlspecialchars($student['profile_photo']); ?>" 
                        class="viewprofile-img"
                        alt="Profile Photo"
                    >
                </div>
                <div class="profile-info">
                    <h1>
                        <?php 
                        echo htmlspecialchars($student['firstname'] ?? 'First Name') . ' ' . 
                             htmlspecialchars($student['lastname'] ?? 'Last Name'); 
                        ?>
                    </h1>
                    <div class="button-group">
                        <a href="/student-edit-profile" class="edit-button">Edit Profile</a>
                        <a href="/student-delete-profile" class="delete-button">Delete Profile</a>
                    </div>
                </div>
            </div>

            <div class="viewprofile-details">
                <div class="detail-item">
                    <strong>Email:</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['email'] ?? 'Email not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Phone</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['phonenumber'] ?? 'Phone not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Date of Birth</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['dateofbirth'] ?? 'DOB not available'); ?>
                    </span>
                </div>
                <div class="detail-item">
                    <strong>Registration Date</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['registration_date'] ?? ' not available'); ?>
                    </span>
                </div>

                <div class="detail-item">
                    <strong>Grade</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['grade'] ?? ' not available'); ?>
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
                        <?php echo htmlspecialchars($student['points'] ?? ' not available'); ?>
                    </span>
                </div>

                <!--last login-->
                <div class="detail-item">
                    <strong>Last Login</strong>
                    <span class="detail-value">
                        <?php echo htmlspecialchars($student['last_login'] ?? ' not available'); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>