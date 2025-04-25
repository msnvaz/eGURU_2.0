<?php
use App\Controllers\TutorAdDisplayController;

if (!isset($ads)) {
    require_once __DIR__ . '/../Controllers/TutorAdDisplayController.php';

    $controller = new TutorAdDisplayController();
    $ads = $controller->getAds(); // This should return the ads without rendering the view
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tutor Ads</title>
</head>
<style>
    ul {
        display: flex;
        gap: 15px;
        list-style: none;
        padding: 0;
    }

    li {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
    }

        img {
            border-radius: 6px;
        }
</style>

<body>
    <h2>Unique Tutor Ads</h2>
    <?php if (!empty($ads) && is_array($ads)): ?>
        <ul>
            <?php foreach ($ads as $ad): ?>
                <li>
                <img src="images/<?= htmlspecialchars($ad['ad_display_pic']) ?>" width="300" height="300" alt="Ad Pic">

                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No ads found.</p>
    <?php endif; ?>
</body>
</html>
