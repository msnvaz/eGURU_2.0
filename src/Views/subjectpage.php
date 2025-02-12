<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Science Tutors</title>
    <link rel="stylesheet" href="/css/subjectpage.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">
    <style>
        /* Filter Section */
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

        /* Tutor Cards */
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
            color: #FFD700; /* Gold stars */
        }

        /* Availability Status */
        .status {
            margin-top: 10px;
            padding: 5px 10px;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
        }
        .available-status {
            background-color: #4CAF50;
            color: white;
        }
        .busy-status {
            background-color: #FF5722;
            color: white;
        }

        /* See More Button */
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

        /* Tutor Profile Image */
.profile-img {
    width: 100px; /* Adjust size as needed */
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    display: block;
    margin: 0 auto 10px; /* Center image */
    border: 3px solid #ddd; /* Optional border for better styling */
}


    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
    <header class="header">
        <img src="images/Science.png" alt="Science Logo" class="logo">
        <h1><?= htmlspecialchars($subject) ?></h1>  <!-- Dynamic subject name -->

        <!-- Filter Form -->
        <form method="get" action="" class="filter-container">
            <div class="filter">
                <span>Filter by</span>
                <select name="tutor_level" id="grade-filter">
                    <option value="">All Grades</option>
                    <option value="Undergraduate" <?= $gradeFilter == 'Undergraduate' ? 'selected' : '' ?>>Undergraduate</option>
                    <option value="Graduate" <?= $gradeFilter == 'Graduate' ? 'selected' : '' ?>>Graduate</option>
                    <option value="Full-time" <?= $gradeFilter == 'Full-time' ? 'selected' : '' ?>>Full-time</option>
                    <option value="Retired" <?= $gradeFilter == 'Retired' ? 'selected' : '' ?>>Retired</option>
                </select>
            </div>
            <div class="checkbox-wrapper">
                <input type="checkbox" id="available" name="available" <?= $availableOnly ? 'checked' : '' ?>>
                <label for="available">✓ Available</label>
            </div>
            <button type="submit">Apply</button>
        </form>
    </header>

    <div class="tutor-list">
    <?php foreach ($tutors as $tutor): ?>
        <a href="/tutorpreview?tutor_id=<?= urlencode($tutor['tutor_id']) ?>" class="tutor-card">
            <img src="<?= htmlspecialchars($tutor['profile_image']) ?>"
                 alt="<?= htmlspecialchars($tutor['name']) ?>'s Profile"
                 class="profile-img">
            
            <div class="info">
                <h3><?= htmlspecialchars($tutor['name']) ?></h3>
                <p><?= htmlspecialchars($tutor['tutor_level']) ?></p>
                <p>Investment per hour: LKR.<?= number_format($tutor['hour_fees']) ?></p>
                <div class="rating">
                    <?php
                    $rating = (int)$tutor['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $rating ? '⭐' : '☆';
                    }
                    ?>
                </div>
            </div>

            <div class="status <?= strtolower($tutor['availability']) ?>-status">
                <?= htmlspecialchars($tutor['availability']) ?>
            </div>
        </a>
    <?php endforeach; ?>
</div>
</div>


        <?php if (count($tutors) >= 10): ?>
            <button class="subject-page-see-more">See More</button>
        <?php endif; ?>
    </div>
    
    <script src="script.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>
`