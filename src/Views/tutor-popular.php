<?php

use App\Models\TutorDisplayModel;

$tutorModel = new TutorDisplayModel();

$popularTutors = $tutorModel->getScheduledTutors(); 
?>
<style>
.tutor-gallery {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
    background-color: #f0f0f0;
}

.tutors {
    display: flex;
    overflow-x: auto;
    gap: 20px;
    padding: 10px;
    scroll-behavior: smooth;
}

.tutors::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
}

.tutor {
    position: relative;
    text-align: center;
    margin: 10px;
    border: 2px solid var(--dark-blue);
    border-left: 4px solid var(--dark-blue);
    padding-left: 20px;
    border-radius: 12px;
    background: #fff;
    min-width: 220px; /* Important: To enable horizontal scrolling */
}

.tutor img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
}

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
    border: 4px solid #CD7F32;  
    box-shadow: 0 0 10px rgba(205, 127, 50, 0.3);
}

.tutor.rank-4 img {
    border: 4px solid #1E90FF;  
    box-shadow: 0 0 10px rgba(30, 144, 255, 0.3);
}

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

<div class="most-popular-section">
    <div class="tutor-gallery">
        <button class="gallery-btn prev" onclick="scrollPopularTutors(-1)">&lt;</button>
        <div class="tutors" id="popularTutors">
            <?php 
            foreach ($popularTutors as $index => $tutor) {
                $rank = $index + 1;
                $rankClass = ($rank <= 4) ? "rank-$rank" : "";
                
                echo '<div class="tutor ' . $rankClass . '">';
                
                if ($rank <= 4) {
                    echo '<div class="rank-badge">' . $rank . '</div>';
                }

                $photoPath = 'images/tutor_uploads/tutor_profile_photos/';
                $defaultPhoto = 'default.jpg';
                $profilePhoto = !empty($tutor['tutor_profile_photo']) ? htmlspecialchars($tutor['tutor_profile_photo']) : $defaultPhoto;
                $photoFullPath = __DIR__ . '/../../public/' . $photoPath . $profilePhoto;
                if (!file_exists($photoFullPath)) {
                    $profilePhoto = $defaultPhoto;
                }
                echo '<img src="' . $photoPath . $profilePhoto . '" alt="Tutor Photo">';

                $fullName = htmlspecialchars($tutor['tutor_first_name']) . ' ' . htmlspecialchars($tutor['tutor_last_name']);
                echo '<span>' . $fullName . ' (' . htmlspecialchars($tutor['scheduled_sessions']) . ' Scheduled)</span>';

                if (!empty($tutor['subjects'])) {
                    echo '<div class="tutor-subjects">' . implode(', ', array_map('htmlspecialchars', $tutor['subjects'])) . '</div>';
                } else {
                    echo '<div class="tutor-subjects">Subjects not available</div>';
                }

                echo '</div>';
            }
            ?>
        </div>
        <button class="gallery-btn next" onclick="scrollPopularTutors(1)">&gt;</button>
    </div>
</div>

<script>
function scrollPopularTutors(direction) {
    const container = document.getElementById("popularTutors");
    const scrollAmount = 220; // Same scroll amount as your other gallery
    container.scrollBy({ left: direction * scrollAmount, behavior: "smooth" });
}
</script>
