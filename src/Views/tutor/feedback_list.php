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
            color: rgba(41, 50, 65,1);
        }

        
        .modal {
            display: none; 
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.59); 
        }

        
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

<?php if ($successMessage || $errorMessage): ?>
    <div id="messageModal" class="modal" style="display: block;">
        <div class="modal-content">
            <span class="close" onclick="closeMessageModal()">&times;</span>
            <h2><?= $successMessage ? 'Success' : 'Error' ?></h2>
            <hr style="color:#adb5bd;">
            <br>
            <p style="text-align:center; color: <?= $successMessage ? 'black' : 'red' ?>;">
                <?= htmlspecialchars($successMessage ?? $errorMessage) ?>
            </p>
            <div class="modal-actions" >
                <button style="margin-left:43%;" class="confirm-button" onclick="closeMessageModal()">OK</button>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
        const url = new URL(window.location);
        url.searchParams.delete('success');
        url.searchParams.delete('error');
        window.history.replaceState({}, document.title, url);
    }
</script>


<?php include 'sidebar.php'; ?>


<?php include '../src/Views/tutor/header.php'; ?>

<div id="feedbackList">
    <h2>Your Students' Feedback</h2>

    <?php foreach ($feedbacks as $feedback) : ?>
        <div class="feedback-item">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 2%;">
                <img src="/images/student-uploads/profilePhotos/<?= $feedback['student_profile_photo'] ?>" alt="User Image"  onerror="this.onerror=null; this.src='/images/tutor_uploads/tutor_profile_photos/default_tutor.png';" class="feedback-img" style="width: 60px; height: 60px; border-radius: 50%;">
                <div>
                    <div>
                        <a style="text-decoration:none;" href="/tutor-student-profile/<?= $feedback['student_id'] ?>">
                        <h3 style="text-decoration:none; color: rgba(41, 50, 65,1)!important;"><?= htmlspecialchars($feedback['student_name']) ?> - Session ID: <?= htmlspecialchars($feedback['session_id']) ?></a></h3>
                    </div>
                     
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
                    <form method="POST" action="/update-reply">
                        <input type="hidden" name="feedback_id" value="<?= $feedback['feedback_id'] ?>">
                        <textarea name="reply" id="editReply_<?= $feedback['feedback_id'] ?>"><?= htmlspecialchars($feedback['tutor_reply']) ?></textarea>
                        <button type="submit" class="btn-save">Save Changes</button>
                        <button type="button" class="btn-cancel" onclick="cancelEdit(<?= $feedback['feedback_id'] ?>)">Cancel</button>
                    </form>
                </div>
            <?php else : ?>
                <div class="create-reply-container">
                    <form method="POST" action="/submit-reply">
                        <input type="hidden" name="feedback_id" value="<?= $feedback['feedback_id'] ?>">
                        <textarea name="reply" id="reply_<?= $feedback['feedback_id'] ?>" placeholder="Type your reply..."></textarea>
                        <button type="submit" class="btn-reply">Save Reply</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<script>
function editReply(feedbackId) {
    document.getElementById("replyContainer_" + feedbackId).style.display = 'none';
    document.getElementById("editContainer_" + feedbackId).style.display = 'block';
}

function cancelEdit(feedbackId) {
    document.getElementById("replyContainer_" + feedbackId).style.display = 'block';
    document.getElementById("editContainer_" + feedbackId).style.display = 'none';
}
</script>

</body>
</html>
