<?php

use App\Models\TutorDisplayModel;

// Instantiate the TutorDisplayModel class
$tutorModel = new TutorDisplayModel();

// Fetch the list of successful tutors
$successfulTutors = $tutorModel->getSuccessfulTutors();
?>
<style>
.tutor-gallery {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.tutors {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    padding: 10px;
    scroll-behavior: smooth;
}

.tutor {
    position: relative;
    text-align: center;
    padding: 15px;
    background: #f8f8f8;
    border-radius: 10px;
    width: 200px;
}

.tutor img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
}

/* Rank Styles */
.tutor.rank-1 img {
    border: 4px solid gold;
    transform: scale(1.1);
    box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
}
.tutor.rank-2 img {
    border: 4px solid silver;
    box-shadow: 0 0 10px rgba(192, 192, 192, 0.3);
}
.tutor.rank-3 img {
    border: 4px solid #CD7F32;  /* bronze */
    box-shadow: 0 0 10px rgba(205, 127, 50, 0.3);
}
.tutor.rank-4 img {
    border: 4px solid #1E90FF;  /* blue */
    box-shadow: 0 0 10px rgba(30, 144, 255, 0.3);
}

/* Rank Badge */
.rank-badge {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
}
.rank-1 .rank-badge { background-color: gold; }
.rank-2 .rank-badge { background-color: silver; }
.rank-3 .rank-badge { background-color: #CD7F32; }
.rank-4 .rank-badge { background-color: #1E90FF; }

/* Subjects Styling */
.subjects {
    font-size: 14px;
    margin-top: 5px;
    font-weight: bold;
    color: #444;
}
.subjects ul {
    list-style-type: none;
    padding: 0;
}
.subjects li {
    display: inline-block;
    background: #e0e0e0;
    margin: 2px;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
}

.gallery-btn {
    font-size: 20px;
    cursor: pointer;
    border: none;
    background: #ddd;
    padding: 10px;
    border-radius: 50%;
    transition: 0.3s;
}
.gallery-btn:hover {
    background: #bbb;
}
</style>

<div class="tutor-gallery">
    <button class="gallery-btn prev" onclick="scrollTutors(-1)">&lt;</button>
    <div class="tutors">
        <?php 
        $maxTutors = 4; // Show only the first four tutors
        foreach (array_slice($successfulTutors, 0, $maxTutors) as $index => $tutor) {
            $rank = $index + 1;
            $rankClass = "rank-$rank";
            
            echo '<div class="tutor ' . $rankClass . '">';
            echo '<div class="rank-badge">' . $rank . '</div>';
            echo '<img src="images/tutor_uploads/tutor_profile_photos/' . htmlspecialchars($tutor['tutor_profile_photo']) . '" alt="' . htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']) . '">';
            echo '<h3>' . htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']) . '</h3>';
            
            // Display subjects
            if (!empty($tutor['subjects'])) {
                echo '<div class="subjects"><ul>';
                foreach ($tutor['subjects'] as $subject) {
                    echo '<li>' . htmlspecialchars($subject) . '</li>';
                }
                echo '</ul></div>';
            }
            
            echo '</div>';
        }
        ?>
    </div>
    <button class="gallery-btn next" onclick="scrollTutors(1)">&gt;</button>
</div>

<script>
function scrollTutors(direction) {
    const container = document.querySelector(".tutors");
    const scrollAmount = 220; // Adjust scrolling distance per click
    container.scrollBy({ left: direction * scrollAmount, behavior: "smooth" });
}
</script>
