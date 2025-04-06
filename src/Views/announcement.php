<?php
require_once __DIR__ . '/../Controllers/DisplayAnnouncementController.php';

use App\Controllers\DisplayAnnouncementController;

$controller = new DisplayAnnouncementController();
$announcements = $controller->displayAnnouncements();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .announcement-card {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #007bff;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
        .announcement-card h3 {
            margin: 0;
            color: #007bff;
            font-size: 18px;
        }
        .announcement-card p {
            margin: 5px 0 0;
            color: #555;
            font-size: 14px;
        }
        .no-announcements {
            text-align: center;
            color: #777;
            font-size: 16px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>📢 Announcements</h2>

        <?php if (!empty($announcements)): ?>
            <?php foreach ($announcements as $announcement): ?>
                <div class="announcement-card">
                    <h3><?= htmlspecialchars($announcement['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($announcement['announcement'])) ?></p>
                    <p class="updated-at" style="text-align:right">🕒 Updated on: <?= htmlspecialchars($announcement['updated_at']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-announcements">
                ❌ No announcements found.
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
