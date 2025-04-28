<?php 
use App\Models\ForumModel;

$model = new ForumModel();
$mainComments = $model->getComments(0);

function renderReplies($parentId, $model, $level = 1) {
    $replies = $model->getComments($parentId);
    foreach ($replies as $reply) {
        ?>
        <div class="reply" style="margin-left: <?= ($level * 40) ?>px;">
            <h4><?= htmlspecialchars($reply['name']) ?></h4>
            <p><?= htmlspecialchars($reply['date']) ?></p>
            <p><?= nl2br(htmlspecialchars($reply['comment'])) ?></p>
            <button class="forum-reply-btn" onclick="reply(<?= $reply['forum_id'] ?>, '<?= addslashes(htmlspecialchars($reply['name'])) ?>')">Reply</button>
            <?php renderReplies($reply['forum_id'], $model, $level + 1); ?>
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .forum-section {
            font-family: 'poppins',sans-serif;
        }
        .forum-container {
            background: white;
            width: 700px;
            margin: 0 auto;
            padding-top: 1px;
            padding-bottom: 5px;
        }
        .comment,
        .reply {
            margin-top: 5px;
            padding: 10px;
            border-bottom: 1px solid black;
        }
        .reply {
            border: 1px solid #ccc;
        }
        p {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        form {
            margin: 10px;
            border: 2px solid var(--dark-blue);padding-left:20px;
            border-radius:12px;
            padding: 10px;
        }
        form h3 {
            margin-bottom: 5px;
            margin-top: 5px;
        }
        form input,
        form textarea {
            border-radius:12px;
            width: 95%;
            padding: 5px;
            margin-bottom: 10px;
            border: 2px solid var(--dark-blue);padding-left:20px;
        }
        .forum-submit-btn {
            background: var(--dark-pink);
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
            border-radius: 12px;
            width: 100%;
        }
        .forum-reply-btn {
            background-color: #E14177;
            border-radius:5px;
            color: white;
            border: none;
            cursor: pointer;
            padding: 8px 15px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<section id="forum">
<div class="forum-section">
    <div class="forum-container" id="comments-section">

        <?php if (!empty($mainComments)) : ?>
            <?php foreach ($mainComments as $comment): ?>
                <div class="comment" style="border: 2px solid var(--dark-blue);padding-left:20px;">
                    <h4><?= htmlspecialchars($comment['name']) ?></h4>
                    <p><?= htmlspecialchars($comment['date']) ?></p>
                    <p style="font-weight:550;padding-left:20px;"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                    <button class="forum-reply-btn" onclick="reply(<?= $comment['forum_id'] ?>, '<?= addslashes(htmlspecialchars($comment['name'])) ?>')">Reply</button>
                    <?php renderReplies($comment['forum_id'], $model); ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="padding:10px;">No Questions yet. Be the first to ask!</p>
        <?php endif; ?>

        <form id="comment-form" action="/forum" method="post">
            <h3 id="title">Leave a Question</h3>
            <input type="hidden" name="reply_id" id="reply_id" value="0">
            <input type="text" name="name" placeholder="Your name" required >
            <textarea name="comment" placeholder="Your comment" required></textarea>
            <button class="forum-submit-btn" type="submit" name="submit">Submit</button>
        </form>
    </div>
    <br><br>
</div>
</section>

<script>
    function reply(id, name) {
        document.getElementById('title').innerText = "Reply to " + name;
        document.getElementById('reply_id').value = id;
        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
    }

    document.getElementById('comment-form').addEventListener('submit', function (e) {
        e.preventDefault(); // prevent default form submission
        const form = e.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('comments-section').innerHTML = html;
            form.reset();
            document.getElementById('reply_id').value = 0;
            document.getElementById('title').innerText = "Leave a Comment";
            // Show success popup
            alert("Comment submitted successfully!");
        })
        .catch(err => {
            alert("Error submitting comment.");
            console.error(err);
        });
    });
</script>
</body>
</html>
