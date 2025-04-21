<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tutor Feedback Dashboard</title>
    <link rel="stylesheet" href="/css/tutor/feedback_list.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .rating-number-text {
            text-align: center;
            margin-left: 2%;
            font-size: 16px;
            color: #000000;
        }

        /* Modal Background */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.59); /* dark background */
        }

        /* Modal Content Box */
        .modal-content {
            border-top: 6px solid  #e03570;
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
            align-items: center;
        }

        /* Close Button (X) */
        .close {
            position: absolute;
            top: 12px;
            right: 18px;
            font-size: 24px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        /* Modal Buttons */
        .modal-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .confirm-button {
            background-color: #ff4081;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .confirm-button:hover {
            background-color: #e03570;
        }

        .modal-cancel-button {
            background-color: #ddd;
            color: #333;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-cancel-button:hover {
            background-color: #bbb;
        }
    </style>
</head>
<body>

<?php
$successMessage = isset($_GET['success']) && !empty($_GET['success']) ? $_GET['success'] : null;
$errorMessage = isset($_GET['error']) && !empty($_GET['error']) ? $_GET['error'] : null;
?>

<!-- ✅ MODAL TEMPLATE -->
<div id="messageModal" class="modal" style="display: <?= ($successMessage || $errorMessage) ? 'block' : 'none' ?>;">
    <div class="modal-content">
        <span class="close" onclick="closeMessageModal()">&times;</span>
        <h2 id="modalTitle"><?= $successMessage ? 'Success' : ($errorMessage ? 'Error' : '') ?></h2>
        <hr style="color:#adb5bd;">
        <br>
        <p id="modalMessage" style="text-align:center; color: <?= $successMessage ? 'black' : 'red' ?>;">
            <?= htmlspecialchars($successMessage ?? $errorMessage) ?>
        </p>
        <div class="modal-actions">
            <button style="margin-left:43%;" class="confirm-button" onclick="closeMessageModal()">OK</button>
        </div>
    </div>
</div>

<script>
function closeMessageModal() {
    document.getElementById('messageModal').style.display = 'none';
    const url = new URL(window.location);
    url.searchParams.delete('success');
    url.searchParams.delete('error');
    window.history.replaceState({}, document.title, url);
}

// ✅ Show modal with dynamic message
function showMessage(message, isSuccess = false) {
    document.getElementById("messageModal").style.display = "block";
    document.getElementById("modalTitle").innerText = isSuccess ? "Success" : "Error";
    document.getElementById("modalMessage").innerText = message;
    document.getElementById("modalMessage").style.color = isSuccess ? "black" : "red";
}
</script>


<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>

<div id="feedbackList">
    <h2>Your Students' Feedback</h2>

    <?php foreach ($feedbacks as $feedback) : ?>
        <div class="feedback-item">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2%;">
                <img src="/images/student-uploads/profilePhotos/<?= $feedback['student_profile_photo'] ?>" alt="User Image" class="feedback-img" style="width: 40px; height: 40px; border-radius: 50%;">
                <div>
                    <strong><?= htmlspecialchars($feedback['student_name']) ?></strong> - Session ID: <?= htmlspecialchars($feedback['session_id']) ?>
                </div>
            </div>

            <div id="session_rating_<?= $feedback['feedback_id'] ?>" style="display: flex; align-items: center; gap: 10px; margin-bottom: 2%;">
                <div class="stars" id="starContainer_<?= $feedback['feedback_id'] ?>"></div>
                <span class="rating-number-text" id="ratingNumber_<?= $feedback['feedback_id'] ?>">
                    <?= isset($feedback['session_rating']) && $feedback['session_rating'] !== null ? $feedback['session_rating'] : '0' ?>/5 stars
                </span>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const rating = parseFloat(document.getElementById("ratingNumber_<?= $feedback['feedback_id'] ?>").textContent);
                    const starContainer = document.getElementById("starContainer_<?= $feedback['feedback_id'] ?>");
                    if (!starContainer) return;

                    const maxStars = 5;
                    starContainer.innerHTML = "";
                    for (let i = 1; i <= maxStars; i++) {
                        const star = document.createElement("span");
                        star.classList.add("star");
                        if (i <= Math.floor(rating)) {
                            star.classList.add("filled");
                            star.innerHTML = "&#9733;";
                        } else if (i === Math.ceil(rating) && rating % 1 !== 0) {
                            star.classList.add("half-filled");
                            star.innerHTML = "&#9733;";
                        } else {
                            star.innerHTML = "&#9733;";
                        }
                        starContainer.appendChild(star);
                    }
                });
            </script>

            <p><?= htmlspecialchars($feedback['student_feedback']) ?></p>
            <small><?= $feedback['time_created'] ?></small>

            <?php if ($feedback['tutor_reply']) : ?>
                <div class="tutor-reply" id="replyContainer_<?= $feedback['feedback_id'] ?>">
                    <strong>Your Reply:</strong>
                    <p id="replyText_<?= $feedback['feedback_id'] ?>"><?= htmlspecialchars($feedback['tutor_reply']) ?></p>
                    <button class="btn-edit" onclick="editReply(<?= $feedback['feedback_id'] ?>)">Edit Reply</button>
                </div>

                <div class="edit-reply-container" id="editContainer_<?= $feedback['feedback_id'] ?>" style="display: none;">
                    <textarea id="editReply_<?= $feedback['feedback_id'] ?>"><?= htmlspecialchars($feedback['tutor_reply']) ?></textarea>
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
        showMessage("Reply cannot be empty.", false);
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
            window.location.href = window.location.pathname + '?success=Reply saved successfully';
        } else {
            showMessage(data.error || 'An error occurred.', false);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showMessage("An unexpected error occurred.", false);
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
        showMessage("Reply cannot be empty.", false);
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
            window.location.href = window.location.pathname + '?success=Reply updated successfully';
        } else {
            showMessage(data.error || 'An error occurred.', false);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showMessage("An unexpected error occurred.", false);
    });
}

</script>

</body>

</html>
