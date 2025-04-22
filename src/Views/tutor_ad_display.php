<!-- <div class="color-section" >
            <br><br><br><br>
            <h2 class="section-title">Meet Some of Our Best Tutors</h2>
            <br>
            <div class="slider-container">
                <button class="slider-btn prev">&lt;</button>
                <div class="slider-wrapper">
                    <div class="slider">
                        <img src="uploads/ad_1.jpeg" alt="Tuition Classes">
                        <img src="uploads/ad_2.jpeg" alt="Home Tuition">
                        <img src="uploads/ad_3.jpeg" alt="Online Tutoring">
                    </div>
                </div>
                <button class="slider-btn next">&gt;</button>
            </div>
</div> -->
<!DOCTYPE html>
<html>
<head>
    <title>Tutor Ads</title>
</head>
<body>
    <h2>Unique Tutor Ads</h2>

    <?php if (!empty($ads) && is_array($ads)): ?>
        <ul>
            <?php foreach ($ads as $ad): ?>
                <li>
                    Tutor ID: <?= esc($ad['tutor_id']) ?> <br>
                    <img src="<?= base_url('uploads/ad_pics/' . $ad['ad_display_pic']) ?>" width="100" alt="Ad Pic">
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No ads found.</p>
    <?php endif; ?>
</body>
</html>
