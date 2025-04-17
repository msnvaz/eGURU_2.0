<section id="search">
    <div class="search-container">
        <h3 class="search-heading">Search to Find the Most Suitable Tutor for You</h3>
        <form method="GET" action="">
            <div class="search-form">
                <select name="grade">
                    <option value="" disabled selected>Grade</option>
                    <option value="grade6">Grade 6</option>
                    <!-- Add more options dynamically if needed -->
                </select>
                <select name="subject">
                    <option value="" disabled selected>Subject</option>
                    <option value="mathematics">Mathematics</option>
                    <!-- Add more options dynamically if needed -->
                </select>
                <select name="level">
                    <option value="" disabled selected>Tutor Level</option>
                    <option value="Degree Holding School Teachers">Degree Holding School Teachers</option>
                    <option value="Junior Teachers, Training Teachers">Junior Teachers, Training Teachers</option>
                    <!-- More levels -->
                </select>
                <select name="rating">
                    <option value="" disabled selected>Rating</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
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

    <!-- Search Results Section -->
    <div class="result-container">
        <h1>Tutor Results</h1>

        <?php
        include "models/tutor_model.php";
        $filters = $_GET ?? [];
        $tutors = getFilteredTutors($filters);

        foreach ($tutors as $tutor) {
            ?>
            <div class="tutor-card">
                <img src="images/tutor_2.jpeg" alt="Tutor Image">
                <div class="tutor-info">
                    <h2><?= htmlspecialchars($tutor['tutor_first_name'] . " " . $tutor['tutor_last_name']) ?></h2>
                    <p><?= htmlspecialchars($tutor['level']) ?></p>
                    <p class="rating">Rating:
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo $i <= $tutor['average_rating'] ? "<span>★</span>" : "<span>☆</span>";
                        }
                        ?>
                    </p>
                </div>
                <button class="status <?= strtolower($tutor['availability']) ?>"><?= ucfirst($tutor['availability']) ?></button>
            </div>
        <?php } ?>

        <button class="see-more">See More</button>
    </div>
</section>
