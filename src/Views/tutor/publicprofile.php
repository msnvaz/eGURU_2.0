<?php
        include 'sidebar.php';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="/css/tutor/publicprofile.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/navbar.css">
</head>
<body>
<?php include '../src/Views/navbar.php'; ?>
    <div class="profile-container">
        <div class="profile-header">
            <img src="\images\review\review3.jpeg" alt="Profile Picture" class="profile-pic">
            <h1>Meet Mr. Kavindha!</h1>
            <div class="rating">
                <span>&#9733;&#9733;&#9733;&#9734;&#9734;</span>
                <span>3.0</span>
            </div>
            <div class="reviews">80 Reviews</div>
            <button class="edit-profile">Edit profile</button>
        </div>
        <div class="tabs">
            <button class="tab-button active" onclick="openTab(event, 'About')">About</button>
            <button class="tab-button" onclick="openTab(event, 'Reviews')">Reviews</button>
            <!--<button class="tab-button" onclick="openTab(event, 'Schedule')">Schedule</button>
            <button class="tab-button" onclick="openTab(event, 'Materials')">Materials</button>-->
        </div>
        <div id="About" class="tab-content active">
            <div class="info">
                <div class="info-item">Session Count: 115</div>
                <div class="info-item">Subjects: Mathematics, Science</div>
                <div class="info-item">Teaching Grades: 9-12</div>
                <div class="info-item">Specialization: Algebra, Physics</div>
                <div class="info-item">Bio: Experienced teacher with a passion for STEM education.</div>
                <div class="info-item">Education: MSc in Mathematics</div>
                <div class="info-item">Experience: 10 years in teaching</div>
            </div>
        </div>
        <div id="Reviews" class="tab-content">
            <div class="review-section">
                <div class="review">
                    <img src="\images\review\review1.jpeg" alt="Reviewer 1" class="reviewer-pic">
                    <div class="review-content">
                        <div class="review-header">
                            <span class="reviewer-name">John Doe</span>
                            <span class="review-date">July 20, 2023</span>
                            <div class="star-rating">
                                &#9733;&#9733;&#9733;&#9733;&#9733;
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vehicula dapibus elit ut fermentum.</p>
                    </div>
                </div>
                <div class="review">
                    <img src="\images\review\review2.jpeg" alt="Reviewer 2" class="reviewer-pic">
                    <div class="review-content">
                        <div class="review-header">
                            <span class="reviewer-name">Jane Smith</span>
                            <span class="review-date">August 12, 2023</span>
                            <div class="star-rating">
                                &#9733;&#9733;&#9733;&#9733;&#9734;
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vehicula dapibus elit ut fermentum.</p>
                    </div>
                </div>
                <div class="review">
                    <img src="\images\review\review3.jpeg" alt="Reviewer 3" class="reviewer-pic">
                    <div class="review-content">
                        <div class="review-header">
                            <span class="reviewer-name">Samuel Green</span>
                            <span class="review-date">September 15, 2023</span>
                            <div class="star-rating">
                                &#9733;&#9733;&#9733;&#9733;&#9733;
                            </div>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vehicula dapibus elit ut fermentum.</p>
                    </div>
                </div>
            </div>
        </div>
        <!--<div id="Schedule" class="tab-content">
            <p>Schedule content goes here...</p>
        </div>
       
        <div id="Materials" class="tab-content">
           
        </div> -->
    </div>
    <script src="/js/tutor/publicprofile.js"></script>
</body>
</html>
