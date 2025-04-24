<?php

use App\Models\TutorDisplayModel;

// Instantiate the TutorDisplayModel class
$tutorModel = new TutorDisplayModel();

// Fetch the list of tutors with the highest scheduled sessions
$popularTutors = $tutorModel->getScheduledTutors(); // Assumes this method fetches data in descending order
?>
<style>
.tutor {
    position: relative;
    text-align: center;
    margin: 10px;
}

.tutor img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
}

/* Top ranks styling */
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
</style>

<div class="most-popular-section">
    <div class="tutor-gallery">
        <button class="gallery-btn prev">&lt;</button>
        <div class="tutors">
            <?php 
            foreach ($popularTutors as $index => $tutor) {
                $rank = $index + 1;
                $rankClass = ($rank <= 4) ? "rank-$rank" : "";
                
                echo '<div class="tutor ' . $rankClass . '">';
                
                if ($rank <= 4) {
                    echo '<div class="rank-badge">' . $rank . '</div>';
                }

                // Display tutor profile photo if available
                $profilePhoto = !empty($tutor['tutor_profile_photo']) ? htmlspecialchars($tutor['tutor_profile_photo']) : 'default-profile.png';
                echo '<img src="' . $profilePhoto . '" alt="Tutor Photo">';

                // Display Tutor Name and Scheduled Sessions
                $fullName = htmlspecialchars($tutor['tutor_first_name']) . ' ' . htmlspecialchars($tutor['tutor_last_name']);
                echo '<span>' . $fullName . ' (' . htmlspecialchars($tutor['scheduled_sessions']) . ' Scheduled)</span>';

                // Display Subjects
                if (!empty($tutor['subjects'])) {
                    echo '<div class="tutor-subjects">' . implode(', ', array_map('htmlspecialchars', $tutor['subjects'])) . '</div>';
                } else {
                    echo '<div class="tutor-subjects">Subjects not available</div>';
                }

                echo '</div>';
            }
            ?>
        </div>
        <button class="gallery-btn next">&gt;</button>
    </div>
</div>
