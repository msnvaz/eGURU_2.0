<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminTutorGrades.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    <div class="main">
        <br>
        <div class="grade-cards">
            <?php
            // Display grades as cards
            foreach ($grades as $grade) {
                echo '<div class="grade-card" data-grade-id="' . htmlspecialchars($grade['grade_id']) . '" style="background-color: ' . htmlspecialchars($grade['color']) . ';">';
                echo '<h3 class="grade-card-heading">' . htmlspecialchars($grade['grade']) . '</h3>';
                echo '<p>Qualification: ' . htmlspecialchars($grade['qualification']) . '</p>';
                echo '<h4>Pay per hour: ' . htmlspecialchars($grade['pay_per_hour']) . ' LKR</h4>';
                echo '<div class="edit-button">Edit</div>';
                echo '</div>';
            }

            include_once 'EditGradeModal.html';
            ?>
        </div>
    </div>
</body>
</html>
