<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <br>
        <form method="POST" class="search-form">
            <div class="searchbar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search_term" placeholder="Search by Student/Tutor Name or Email" required>
                <button type="submit" name="search">Search</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th colspan="10" style="text-align: center;border-radius: 20px 20px 0 0;font-size:16px;">Sessions</th>
                </tr>
            </thead>        
            <thead>
                <tr>
                    <th>Session ID</th>
                    <th>Student Name</th>
                    <th>Tutor Name</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Feedback</th>
                    <th>Grade Levels</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sessions)) : ?>
                    <?php foreach ($sessions as $session) : ?>
                        <tr class="expandable-row">
                            <td>
                                <span class="expand-icon">►</span>
                                <?= htmlspecialchars($session['session_id']) ?>
                            </td>
                            <td><?= htmlspecialchars($session['student_firstname'] . ' ' . $session['student_lastname']) ?></td>
                            <td><?= htmlspecialchars($session['tutor_name']) ?></td>
                            <td><?= htmlspecialchars($session['subject_name']) ?></td>
                            <td><?= htmlspecialchars($session['scheduled_date']) ?></td>
                            <td><?= htmlspecialchars($session['scheduled_time']) ?></td>
                            <td><?= htmlspecialchars($session['progress']) ?></td>
                            <td><?= htmlspecialchars($session['status']) ?></td>
                            <td><?= htmlspecialchars($session['feedback']) ?></td>
                            <td><?php
                                $grades = [];
                                if ($session['grade_6']) $grades[] = '6';
                                if ($session['grade_7']) $grades[] = '7';
                                if ($session['grade_8']) $grades[] = '8';
                                if ($session['grade_9']) $grades[] = '9';
                                if ($session['grade_10']) $grades[] = '10';
                                if ($session['grade_11']) $grades[] = '11';
                                echo htmlspecialchars(implode(', ', $grades));
                            ?></td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="10">
                                <div class="details-content">
                                    <div class="details-grid">
                                        <div class="details-grid-item">
                                            <div class="details-section">
                                                <h4>Session Information</h4>
                                                <p><strong>Session ID:</strong> <?= htmlspecialchars($session['session_id']) ?></p>
                                                <p><strong>Subject:</strong> <?= htmlspecialchars($session['subject_name']) ?></p>
                                                <p><strong>Date:</strong> <?= htmlspecialchars($session['scheduled_date']) ?></p>
                                                <p><strong>Time:</strong> <?= htmlspecialchars($session['scheduled_time']) ?></p>
                                                <p><strong>Status:</strong> <?= htmlspecialchars($session['status']) ?></p>
                                                <p><strong>Progress:</strong> <?= htmlspecialchars($session['progress']) ?></p>
                                            </div>
                                        </div>
                                        <div class="details-grid-item">
                                            <div class="details-section">
                                                <h4>Student Details</h4>
                                                <p><strong>Name:</strong> <?= htmlspecialchars($session['student_firstname'] . ' ' . $session['student_lastname']) ?></p>
                                                <p><strong>Email:</strong> <?= htmlspecialchars($session['student_email']) ?></p>
                                            </div>
                                            <div class="details-section">
                                                <h4>Tutor Details</h4>
                                                <p><strong>Name:</strong> <?= htmlspecialchars($session['tutor_name']) ?></p>
                                                <p><strong>Email:</strong> <?= htmlspecialchars($session['tutor_email']) ?></p>
                                            </div>
                                        </div>
                                        <div class="details-grid-item">
                                            <div class="details-section">
                                                <h4>Grade Levels</h4>
                                                <p><?= htmlspecialchars(implode(', ', $grades)) ?></p>
                                            </div>
                                        </div>
                                        <div class="details-grid-item">
                                            <div class="details-section">
                                                <h4>Feedback</h4>
                                                <p><?= htmlspecialchars($session['feedback']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="12">No sessions found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Dropdown functionality
        document.querySelectorAll('.expandable-row').forEach(row => {
            row.addEventListener('click', function() {
                this.classList.toggle('expanded');
                const detailsRow = this.nextElementSibling;
                if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>