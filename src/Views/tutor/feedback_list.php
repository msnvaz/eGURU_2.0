<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Feedback Dashboard</title>
    <link rel="stylesheet" href="/css/tutor/feedback_list.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>

<?php $page="feedback"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>
    
    <div id="feedbackList">
        <h2>Your Students' Feedback</h2>

        <?php foreach ($feedbacks as $feedback) : ?>
    <div class="feedback-item">
        <h3><?= htmlspecialchars($feedback['student_name']) ?> - Session ID: <?= htmlspecialchars($feedback['session_id']) ?></h3>
        <p><?= htmlspecialchars($feedback['student_feedback']) ?></p>
        <small><?= $feedback['time_created'] ?></small>

        <?php if ($feedback['tutor_reply']) : ?>
            <div class="tutor-reply" id="replyContainer_<?= $feedback['feedback_id'] ?>">
                <strong>Your Reply:</strong>
                <p id="replyText_<?= $feedback['feedback_id'] ?>"><?= htmlspecialchars($feedback['tutor_reply']) ?></p>
                <button class="btn-edit" onclick="editReply(<?= $feedback['feedback_id'] ?>)">Edit Reply</button>
            </div>

            <div class="edit-reply-container" id="editContainer_<?= $feedback['feedback_id'] ?>" style="display: none;">
                <textarea id="editReply_<?= $feedback['id'] ?>"><?= htmlspecialchars($feedback['tutor_reply']) ?></textarea>
                <button class="btn-save" onclick="updateReply(<?= $feedback['feedback_id'] ?>)">Save Changes</button>
                <button class="btn-cancel" onclick="cancelEdit(<?= $feedback['feedback_id'] ?>)">Cancel</button>
            </div>
        <?php else : ?>
            <div class="create-reply-container">
                <textarea id="reply_<?= $feedback['feedback_id'] ?>" placeholder="Type your reply..."></textarea>
                <button class="btn-reply" onclick="submitReply(<?= $feedback['feedback_id'] ?>)">Save Reply</button>
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

    </div>

    <script>
        function submitReply(feedbackId) {
    const replyText = document.getElementById(`reply_${feedbackId}`).value.trim();
    if (!replyText) {
        alert("Reply cannot be empty.");
        return;
    }

    fetch('/submit-reply', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `feedback_id=${feedbackId}&reply=${encodeURIComponent(replyText)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'An error occurred.');
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An unexpected error occurred.");
    });
}

function editReply(feedbackId) {
    document.getElementById(`replyContainer_${feedbackId}`).style.display = 'none';
    document.getElementById(`editContainer_${feedbackId}`).style.display = 'block';
}

function cancelEdit(feedbackId) {
    document.getElementById(`replyContainer_${feedbackId}`).style.display = 'block';
    document.getElementById(`editContainer_${feedbackId}`).style.display = 'none';
}

function updateReply(feedbackId) {
    const updatedText = document.getElementById(`editReply_${feedbackId}`).value.trim();
    if (!updatedText) {
        alert("Reply cannot be empty.");
        return;
    }

    fetch('/update-reply', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `feedback_id=${feedbackId}&reply=${encodeURIComponent(updatedText)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.error || 'An error occurred.');
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An unexpected error occurred.");
    });
}

    </script>
</body>
</html>
