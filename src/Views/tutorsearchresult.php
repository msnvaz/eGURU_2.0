<style>
.result-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background: #fdfdfd;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.result-container h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
    font-size: 28px;
}

.tutor-card {
    display: flex;
    align-items: center;
    background-color: #ffffff;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s;
}

.tutor-card:hover {
    transform: translateY(-5px);
}

.tutor-card img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 20px;
    border: 2px solid #ddd;
}

.tutor-info {
    flex: 1;
}

.tutor-info h2 {
    margin: 0;
    font-size: 22px;
    color: #333;
}

.tutor-info p {
    margin: 6px 0;
    font-size: 15px;
    color: #555;
}

.rating span {
    font-size: 18px;
    color: #FFA500; /* Orange for stars */
}

.status {
    background-color: #4682B4;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    cursor: default;
    white-space: nowrap;
}

.see-more {
    display: block;
    margin: 30px auto 0;
    background-color: #4682B4;
    color: #fff;
    border: none;
    padding: 12px 30px;
    font-size: 15px;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.see-more:hover {
    background-color: #2c5a84;
}
</style>

<?php if ($searchPerformed): ?>
<div class="result-container">
    <h1>Tutor Results</h1>
    <?php if (!empty($tutors)): ?>
        <?php foreach ($tutors as $tutor): ?>
            <div class="tutor-card">
                <img src="images/tutor_2.jpeg" alt="Tutor Image">
                <div class="tutor-info">
                    <h2><?= htmlspecialchars($tutor['tutor_first_name']) . ' ' . htmlspecialchars($tutor['tutor_last_name']) ?></h2>
                    <p><strong>Level:</strong> <?= htmlspecialchars($tutor['tutor_level_qualification']) ?></p>
                    <p class="rating">Rating:
                        <?php
                        $rating = round($tutor['average_rating'] ?? 0);
                        for ($i = 1; $i <= 5; $i++):
                            echo $i <= $rating ? "<span>★</span>" : "<span>☆</span>";
                        endfor;
                        ?>
                    </p>
                </div>
                <button class="status"><?= htmlspecialchars($tutor['availability'] ?? 'Not Available') ?></button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No tutors found matching your filters.</p>
    <?php endif; ?>
    <button class="see-more">See More</button>
</div>
<?php endif; ?>
