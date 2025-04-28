<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings and Reviews</title>
    <link rel="stylesheet" href="css/student/rating.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
</head>
<?php $page="rating"; ?>
<body>
<?php include '../src/Views/navbar.php'; ?>
<div class="container">
        
        <?php include 'sidebar.php'; ?>
        <div class="bodyform">
        <div id="reviews" class="rating-content-section">
            <div class="rating-container">
                <h2>Rate Your Tutor</h2><br>

                
                <div class="tutor-cards-container">
                    <div class="arrow arrow-left" onclick="scrollTutorCards('left')"></div>
                    <i class="fas fa-chevron-left"></i>
                    <div class="tutor-card" data-tutor="Mr. Kavinda" onclick="selectTutor(this)">
                        <img src="images/student-uploads/tutor1.jpg" alt="Kavinda">
                        <h4>Mr. Kavinda</h4>
                        <p>Expert in Mathematics</p>
                    </div>
                    <div class="tutor-card" data-tutor="Mr. Dulanjaya" onclick="selectTutor(this)">
                        <img src="images/student-uploads/tutor2.jpg" alt="Dulanjaya">
                        <h4>Mr. Dulanjaya</h4>
                        <p>Science Specialist</p>
                    </div>
                    <div class="tutor-card" data-tutor="Mr. Lahiru " onclick="selectTutor(this)">
                        <img src="images/student-uploads/tutor3.jpg" alt="Lahiru ">
                        <h4>Mr. Lahiru </h4>
                        <p>History Enthusiast</p>
                    </div>
                    <div class="arrow arrow-right" onclick="scrollTutorCards('right')"></div>
                    <i class="fas fa-chevron-right"></i>
                </div>

                <div id="average-rating" class="average-rating">Average Rating: 0.0 (0 Reviews)</div>

                <form id="review-form" class="review-form">
                    <select id="rating" required>
                        <option value="" disabled selected>Select a rating (1-5)</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                    <textarea id="comment" placeholder="Write a review..." rows="4" required></textarea>
                    <button type="button" onclick="addReview()">Submit Review</button>
                </form>

                <div id="review-list" class="review-list">
                    


                </div>

                
                <button class="clear-history-btn" onclick="clearHistory()">Clear History</button>
            </div>
        </div>
    </div>
</div>

<script src="js/student/rating.js"></script>

</body>
</html>
