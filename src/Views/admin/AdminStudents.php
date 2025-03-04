<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <div class="admin-dashboard">
            <br>
            <div class="profile-tabs">
                <a href="/admin-students" class="tab-link <?= !isset($deletedStudents) ? 'active' : '' ?>">Active Students</a>
                <a href="/admin-deleted-students" class="tab-link <?= isset($deletedStudents) ? 'active' : '' ?>">Deleted Students</a>
            </div>
            <br>
            <form method="POST" class="search-form">
                <div class="searchbar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search_term" placeholder='Search by ID, Name or Email' required>
                    <button type="submit" name="search">Search</button>
                </div>
            </form>

            <div class="student-cards">
                <?php if (isset($deletedStudents)): ?>
                    <?php if (!empty($deletedStudents) && is_array($deletedStudents)): ?>
                        <?php foreach ($deletedStudents as $row): ?>
                            <div class="student-card deleted">
                                <a href="/admin-student-profile/<?= isset($row['student_id']) ? htmlspecialchars($row['student_id']) : ''; ?>" class="student-card-link">
                                    <img src="uploads/Student_Profiles/<?= !empty($row['student_profile_photo']) ? htmlspecialchars($row['student_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="student-photo">
                                    <p class="student-name"> <?= htmlspecialchars($row['student_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($row['student_last_name'] ?? 'Last Name'); ?></p>
                                    <p class="student-email"> <?= htmlspecialchars($row['student_email'] ?? 'Email not available'); ?></p>
                                    <p class="student-registration">Deleted on: <?= htmlspecialchars($row['stduent_registration_date'] ?? 'Unknown'); ?></p>
                                    <p class="student-points">Student ID : <?= htmlspecialchars($row['student_id'] ?? 'Not Found'); ?></p>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No deleted students found.</p>
                    <?php endif; ?>
                <?php elseif (!empty($students) && is_array($students)): ?>
                    <?php foreach ($students as $row): ?>
                        <div class="student-card">
                            <a href="/admin-student-profile/<?= htmlspecialchars($row['student_id'] ?? ''); ?>" class="student-card-link">
                                <img src="uploads/Student_Profiles/<?= htmlspecialchars($row['student_profile_photo'] ?? 'default.jpg'); ?>" alt="Profile Photo" class="student-photo">
                                <p class="student-name"> <?= htmlspecialchars($row['student_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($row['student_last_name'] ?? 'Last Name'); ?></p>
                                <p class="student-email"> <?= htmlspecialchars($row['student_email'] ?? 'Email not available'); ?></p>
                                <p class="student-registration">Registered on: <?= htmlspecialchars($row['student_registration_date'] ?? 'Unknown'); ?></p>
                                <p class="student-points">Student ID : <?= htmlspecialchars($row['student_id'] ?? 'Not Found'); ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No students found.</p>
                <?php endif; ?>
            </div>
        </div>  
    </div>
</body>
</html>
