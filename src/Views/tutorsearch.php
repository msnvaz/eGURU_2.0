<form method="GET" action="/tutor/search">
    <div class="search-form">
        <select name="grade">
            <option value="" disabled <?= empty($_GET['grade']) ? 'selected' : '' ?>>Grade</option>
            <?php foreach (range(6, 11) as $g): ?>
                <option value="<?= $g ?>" <?= isset($_GET['grade']) && $_GET['grade'] == $g ? 'selected' : '' ?>>
                    <?= $g ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="subject">
            <option value="" disabled <?= empty($_GET['subject']) ? 'selected' : '' ?>>Subject</option>
            <?php
            $subjects = ["mathematics", "science", "tamil", "history", "geography", "buddhism", "information technology", "physics", "chemistry", "biology"];
            foreach ($subjects as $s): ?>
                <option value="<?= $s ?>" <?= isset($_GET['subject']) && $_GET['subject'] == $s ? 'selected' : '' ?>>
                    <?= ucfirst($s) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="level">
            <option value="" disabled <?= empty($_GET['level']) ? 'selected' : '' ?>>Tutor Level</option>
            <?php
            $levels = [
                "Degree Holding School Teachers",
                "Experienced Undergraduates, Trainee Teachers",
                "Undergraduates",
                "Diploma Holders",
                "Post AL Students / Other"
            ];
            foreach ($levels as $level): ?>
                <option value="<?= $level ?>" <?= isset($_GET['level']) && $_GET['level'] == $level ? 'selected' : '' ?>>
                    <?= $level ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="rating">
            <option value="" disabled <?= empty($_GET['rating']) ? 'selected' : '' ?>>Rating</option>
            <?php foreach (range(1, 5) as $r): ?>
                <option value="<?= $r ?>" <?= isset($_GET['rating']) && $_GET['rating'] == $r ? 'selected' : '' ?>>
                    <?= $r ?> Star<?= $r > 1 ? 's' : '' ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="session_count">
            <option value="" disabled <?= empty($_GET['session_count']) ? 'selected' : '' ?>>Session Count</option>
            <option value="5" <?= isset($_GET['session_count']) && $_GET['session_count'] == 5 ? 'selected' : '' ?>>Up to 5 sessions</option>
            <option value="10" <?= isset($_GET['session_count']) && $_GET['session_count'] == 10 ? 'selected' : '' ?>>Up to 10 sessions</option>
            <option value="15" <?= isset($_GET['session_count']) && $_GET['session_count'] == 15 ? 'selected' : '' ?>>More than 10 sessions</option>
        </select>
    </div>
    <button class="search-button" type="submit">Search</button>
</form>

