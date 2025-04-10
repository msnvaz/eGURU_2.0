<section id="forum">
    <div class="forum-container">
        <br><br><br>
        <h2>Forum</h2>
        <br>

        <?php $messages = $messages ?? []; ?>

        <?php if (!empty($messages)): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="comment">
                    <div class="forum-profile">
                        <img class="avatar" src="images/tutor_2.jpeg" alt="Tutor Image">
                        <div class="name"><?= htmlspecialchars($msg['student_first_name']) ?></div>
                    </div>
                    <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                    <div class="forum-footer">
                        <span><?= date("h:i A", strtotime($msg['time'])) ?></span>
                        <button class="reply-btn">Reply</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No forum messages available yet.</p>
        <?php endif; ?>

        <button class="forum-see-more">See More</button>
    </div>
</section>
