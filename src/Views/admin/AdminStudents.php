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
            <h2>Student Profiles</h2>
            <!-- Search Form -->
            <form method="POST" class="search-form">
                <div class="searchbar">
                    <i class="fa-solid fa-magnifying-glass" style="padding:0;margin:0;"></i>
                    <input type="text" name="search_term" placeholder='Search by ID,Name or Email' required>
                    <button type="submit" name="search">
                    Search
                    </button>
                </div>
            </form>

            <!-- Student Cards -->
            <div class="student-cards">
                <?php if (!empty($students) && is_array($students)): ?>
                    <?php foreach ($students as $row): ?>
                        <div class="student-card">
                        <a href="/admin-student-profile/<?= isset($row['id']) ? htmlspecialchars($row['id']) : ''; ?>" class="student-card-link">
                        <img src="uploads/Student_Profiles/<?= !empty($row['profile_photo']) ? htmlspecialchars($row['profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="student-photo">
                                <p class="student-name"><?= !empty($row['firstname']) ? htmlspecialchars($row['firstname']) : 'First Name'; ?></p>
                                <p class="student-name"><?= !empty($row['lastname']) ? htmlspecialchars($row['lastname']) : 'Last Name'; ?></p>
                                <p class="student-email"><?= !empty($row['email']) ? htmlspecialchars($row['email']) : 'Email not available'; ?></p>
                                <p class="student-registration">Registered on: <?= !empty($row['registration_date']) ? htmlspecialchars($row['registration_date']) : 'Unknown'; ?></p>
                                <p class="student-points">Student ID : <?= isset($row['id']) ? htmlspecialchars($row['id']) : 'Not Found'; ?></p>
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
