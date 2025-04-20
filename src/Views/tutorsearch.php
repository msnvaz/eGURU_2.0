<section id="search">
    <div class="search-container">
        <h3 class="search-heading">Search to Find the Most Suitable Tutor for You</h3>
        <form method="GET" action="/tutor/search">
            <div class="search-form">
                <select name="grade">
                    <option value="" disabled selected>Grade</option>
                    <?php foreach (range(6, 11) as $g): ?>
                        <option value="<?= $g ?>"><?= $g ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="subject">
                    <option value="" disabled selected>Subject</option>
                    <?php
                    $subjects = ["mathematics", "science", "tamil", "history", "geography", "buddhism", "information technology", "physics", "chemistry", "biology"];
                    foreach ($subjects as $s): ?>
                        <option value="<?= $s ?>"><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="level">
                    <option value="" disabled selected>Tutor Level</option>
                    <option value="Degree Holding School Teachers">Degree Holding School Teachers</option>
                    <option value="Experienced Undergraduates, Trainee Teachers">Junior Teachers, Training Teachers</option>
                    <option value="Undergraduates">Undergraduates</option>
                    <option value="Diploma Holders">Diploma Holders</option>
                    <option value="Post AL Students / Other">Post AL Students / Other</option>
                </select>

                <select name="rating">
                    <option value="" disabled selected>Rating</option>
                    <?php foreach (range(1, 5) as $r): ?>
                        <option value="<?= $r ?>"><?= $r ?> Star<?= $r > 1 ? 's' : '' ?></option>
                    <?php endforeach; ?>
                </select>

                <select name="session_count">
                    <option value="" disabled selected>Session Count</option>
                    <option value="5">Up to 5 sessions</option>
                    <option value="10">Up to 10 sessions</option>
                    <option value="15">More than 10 sessions</option>
                </select>
            </div>
            <button class="search-button" type="submit">Search</button>
        </form>
    </div>

    <div class="result-container">
        <h1>Tutor Results</h1>

        <?php if (isset($tutors) && is_array($tutors) && count($tutors) > 0): ?>
            <?php foreach ($tutors as $tutor): ?>
                <div class="tutor-card">
                    <img src="images/tutor_2.jpeg" alt="Tutor Image">
                    <div class="tutor-info">
                        <h2>
                            <?= htmlspecialchars($tutor['tutor_first_name'] ?? 'First') . ' ' . htmlspecialchars($tutor['tutor_last_name'] ?? 'Last') ?>
                        </h2>
                        <p>
                            <?= htmlspecialchars($tutor['tutor_level_id'] ?? 'Not Specified') ?>
                        </p>
                        <p class="rating">Rating:
                            <?php
                            $rating = round($tutor['average_rating'] ?? 0);
                            for ($i = 1; $i <= 5; $i++):
                                echo $i <= $rating ? "<span>★</span>" : "<span>☆</span>";
                            endfor;
                            ?>
                        </p>
                    </div>
                    <button class="status">
                        <?= htmlspecialchars($tutor['availability'] ?? 'Not Available') ?>
                    </button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No tutors found matching your filters.</p>
        <?php endif; ?>

        <button class="see-more">See More</button>
    </div>
</section>
