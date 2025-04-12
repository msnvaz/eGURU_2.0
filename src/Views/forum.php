<!DOCTYPE html>
<html>
<head>
    <title>Forum Messages</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .message-box {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .student-name { font-weight: bold; }
        .timestamp { font-size: 0.9em; color: #666; }
    </style>
</head>
<body>
    <h2>Student Forum Messages</h2>
    <?php if (!empty($messages)) : ?>
        <?php foreach ($messages as $msg) : ?>
            <div class="message-box">
                <div class="student-name"><?= htmlspecialchars($msg['student_first_name']) ?></div>
                <div class="timestamp"><?= date("F j, Y, g:i a", strtotime($msg['time'])) ?></div>
                <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No messages yet.</p>
    <?php endif; ?>
</body>
</html>
