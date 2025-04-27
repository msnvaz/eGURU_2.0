<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($subject) ?> Tutors</title>
    <link rel="stylesheet" href="/css/subjectpage.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <style>
        .filter-container {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .availability-filter, .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .tutor-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .tutor-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-decoration: none;
            border-radius: 12px;
            padding: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border: 2px solid #ddd;
        }
        .tutor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
        }
        .tutor-card h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 5px;
        }
        .tutor-card p {
            color: #666;
            font-size: 14px;
        }
        .rating {
            margin-top: 8px;
            font-size: 18px;
            color: #FFD700;
        }
        .status {
            margin-top: 10px;
            padding: 5px 10px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
        }
        .available-status {
            background-color: #E14177;
            color: white;
        }
        .busy-status {
            background-color: #FF5722;
            color: white;
        }
        .subject-page-see-more {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            font-size: 16px;
            color: white;
            background: #007BFF;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .subject-page-see-more:hover {
            background: #0056b3;
        }
        .profile-img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            margin: 0 auto 10px;
            border: 3px solid #ddd;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <header class="header">
        <img src="images/Science.png" alt="Science Logo" class="logo">
        <h1><?= htmlspecialchars($subject) ?></h1>

        <form method="get" action="" class="filter-container">
            <input type="hidden" name="subject" value="<?= htmlspecialchars($subject) ?>">
            <div class="filter">
                <label for="grade-filter">Filter by</label>
                <select name="tutor_level" id="grade-filter" onchange="this.form.submit()">
                    <option value="">All Grades</option>
                    <?php foreach ($tutorLevels as $level): ?>
                        <option value="<?= htmlspecialchars($level['tutor_level']) ?>" <?= $gradeFilter === $level['tutor_level'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($level['tutor_level']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </header>

    <div class="tutor-list">
        <?php if (empty($tutors)): ?>
            <p>No tutors found for the selected filters.</p>
        <?php else: ?>
            <?php foreach ($tutors as $tutor): ?>
                <a href="/tutorpreview?tutor_id=<?= urlencode($tutor['tutor_id']) ?>" class="tutor-card">
                    <img src="<?='images/tutor_uploads/tutor_profile_photos/'. htmlspecialchars($tutor['tutor_profile_photo']) ?>"
                         alt="<?= htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']) ?>'s Profile"
                         class="profile-img">

                    <div class="info">
                        <h3><?= htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']) ?></h3>
                        <p><?= htmlspecialchars($tutor['tutor_level']) ?></p>
                        <p>Investment per hour: LKR.<?= htmlspecialchars($tutor['tutor_pay_per_hour']) ?></p>
                        <div class="rating">
                            <?php
                            $rating = is_numeric($tutor['avg_rating']) ? round($tutor['avg_rating']) : 0;
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $rating ? '⭐' : '☆';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="status <?= isset($tutor['availability_slots']) && $tutor['availability_slots'] ? 'available-status' : 'busy-status' ?>">
                        <?= isset($tutor['availability_slots']) && $tutor['availability_slots'] ? 'Available' : 'Busy' ?>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (count($tutors) >= 10): ?>
        <form method="get" action="" class="see-more-form">
            <input type="hidden" name="subject" value="<?= htmlspecialchars($subject) ?>">
            <input type="hidden" name="tutor_level" value="<?= htmlspecialchars($gradeFilter) ?>">
            <input type="hidden" name="page" value="<?= isset($_GET['page']) ? $_GET['page'] + 1 : 2 ?>">
            <button type="submit" class="subject-page-see-more">See More</button>
        </form>
    <?php endif; ?>
</div>

<script src="script.js"></script>
<?php include 'footer.php'; ?>
</body>
</html>
