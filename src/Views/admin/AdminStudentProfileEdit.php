<?php
// Get student data from controller
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
            <h1>Edit Student Profile</h1>
            
            <form action="/admin-update-student-profile/<?= htmlspecialchars($student['id'] ?? '') ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" 
                           value="<?= htmlspecialchars($student['firstname'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" 
                           value="<?= htmlspecialchars($student['lastname'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" 
                           value="<?= htmlspecialchars($student['email'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="phonenumber">Phone Number:</label>
                    <input type="tel" id="phonenumber" name="phonenumber" 
                           value="<?= htmlspecialchars($student['phonenumber'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="dateofbirth">Date of Birth:</label>
                    <input type="date" id="dateofbirth" name="dateofbirth" 
                           value="<?= htmlspecialchars($student['dateofbirth'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="grade">Grade:</label>
                    <input type="text" id="grade" name="grade" 
                           value="<?= htmlspecialchars($student['grade'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="profile_photo">Profile Photo:</label>
                    <input type="file" id="profile_photo" name="profile_photo">
                    <?php if (!empty($student['profile_photo'])): ?>
                        <p>Current Photo: <?= htmlspecialchars($student['profile_photo']) ?></p>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="save-button">Save Changes</button>
                    <a href="/admin-student-profile/<?= htmlspecialchars($student['id'] ?? '') ?>" class="cancel-button">Cancel</a>
                    </div>
            </form>
        </div>
    </div>
</body>
</html>
