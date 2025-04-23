<?php
require_once __DIR__ . '/../Controllers/DisplayAnnouncementController.php';

use App\Controllers\DisplayAnnouncementController;

// AJAX load more
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'loadMore') {
    $offset = (int)($_POST['offset'] ?? 0);
    $controller = new DisplayAnnouncementController();
    $moreAnnouncements = $controller->displayAnnouncements($offset);
    echo json_encode($moreAnnouncements);
    exit;
}

$controller = new DisplayAnnouncementController();
$announcements = $controller->displayAnnouncements();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .announcement-card {
            background: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 5px solid #007bff;
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.1);
        }
        .announcement-card h3 {
            color: #007bff;
            margin: 0;
        }
        .announcement-card p {
            color: #555;
            font-size: 14px;
            margin-top: 5px;
        }
        .updated-at {
            text-align: right;
            font-size: 12px;
            color: #888;
        }
        .no-announcements {
            text-align: center;
            color: #777;
            font-size: 16px;
        }
        #load-more-btn {
            display: block;
            margin: 20px auto 0;
            padding: 10px 20px;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #load-more-btn:disabled {
            background-color: #aaa;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📢 Announcements</h2>

    <?php if (!empty($announcements)): ?>
        <div id="announcement-list">
            <?php foreach ($announcements as $announcement): ?>
                <div class="announcement-card">
                    <h3><?= htmlspecialchars($announcement['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($announcement['announcement'])) ?></p>
                    <p class="updated-at">🕒 Updated on: <?= htmlspecialchars($announcement['updated_at']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <button id="load-more-btn">🔽 Load More</button>
    <?php else: ?>
        <div class="no-announcements">❌ No announcements found.</div>
    <?php endif; ?>
</div>

<script>
let offset = <?= count($announcements) ?>;

document.getElementById('load-more-btn')?.addEventListener('click', function () {
    const btn = this;
    btn.disabled = true;
    btn.innerText = 'Loading...';

    fetch('/announcement', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `action=loadMore&offset=${offset}`
})

    .then(response => response.json())
    .then(data => {
        if (data.length > 0) {
            const container = document.getElementById('announcement-list');
            data.forEach(a => {
                const card = document.createElement('div');
                card.className = 'announcement-card';
                card.innerHTML = `
                    <h3>${a.title}</h3>
                    <p>${a.announcement.replace(/\n/g, "<br>")}</p>
                    <p class="updated-at">🕒 Updated on: ${a.updated_at}</p>
                `;
                container.appendChild(card);
            });
            offset += data.length;
            btn.innerText = '🔽 Load More';
            btn.disabled = false;
        } else {
            btn.innerText = 'No more announcements';
            btn.disabled = true;
        }
    })
    .catch(err => {
        console.error(err);
        btn.innerText = '🔽 Load More';
        btn.disabled = false;
    });
});
</script>
</body>
</html>
