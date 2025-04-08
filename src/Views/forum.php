<section id="forum">
    <div class="forum-container">
        <br><br><br>
        <h2>Forum</h2>
        <br>

        <?php foreach ($messages as $msg): ?>
        <div class="comment">
            <div class="forum-profile">
                <img class="avatar" src="images/tutor_2.jpeg" alt="Tutor Image">
                <div class="name"><?= htmlspecialchars($msg['name']) ?></div>
            </div>
            <p><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
            <div class="forum-footer">
                <span><?= date("h:i A", strtotime($msg['time'])) ?></span>
                <button class="reply-btn">Reply</button>
            </div>
        </div>
        <?php endforeach; ?>

        <button class="forum-see-more">See More</button>
    </div>
</section>
