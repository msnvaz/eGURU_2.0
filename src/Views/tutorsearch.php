<section id="/tutor/search">
<h2 class="choose-tutor-heading">SEARCH FOR A TUTOR</h2>
<style>
    .choose-tutor-heading {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
    font-weight: bold;
}

.tutor-search-form {
    max-width: 600px;
    margin: 0 auto;
}

.tutor-search-fields {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 15px;
}

.tutor-select {
    flex: 1 1 45%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

.tutor-button-container {
    text-align: center;
    margin-top: 25px;
}

.tutor-search-button {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 30px;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.tutor-search-button:hover {
    background-color: #0056b3;
}

</style>
<form method="GET" action="/tutor/search" class="tutor-search-form">
    <div class="tutor-search-fields">
        <select name="grade" class="tutor-select">
            <option value="" disabled <?= empty($_GET['grade']) ? 'selected' : '' ?>>Grade</option>
            <?php foreach (range(6, 11) as $g): ?>
                <option value="<?= $g ?>" <?= isset($_GET['grade']) && $_GET['grade'] == $g ? 'selected' : '' ?>>
                    <?= $g ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="subject" class="tutor-select">
            <option value="" disabled <?= empty($_GET['subject']) ? 'selected' : '' ?>>Subject</option>
            <?php
            $subjects = ["mathematics", "science", "tamil", "history", "geography", "buddhism", "information technology", "physics", "chemistry", "biology"];
            foreach ($subjects as $s): ?>
                <option value="<?= $s ?>" <?= isset($_GET['subject']) && $_GET['subject'] == $s ? 'selected' : '' ?>>
                    <?= ucfirst($s) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="tutor-button-container">
        <button class="tutor-search-button" type="submit">Search</button>
    </div>
</form>
</section>