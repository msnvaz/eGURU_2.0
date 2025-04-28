<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard</title>
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
<body>

<?php $page="dashboard"; ?>


<?php include 'sidebar.php'; ?>


<?php include '../src/Views/tutor/header.php'; ?>

    <div class="container">

        
        <div class="main-content">
            

            
            <div class="profile-info-container">
                <div class="profile-info" style="background-color: #CBF1F9; padding: 20px; border-radius: 8px;">
                    <div class="welcome">
                        <?php if ($tutorData): ?>
                            <h2>Welcome, <?php echo htmlspecialchars($tutorData['tutor_first_name'] . ' ' . $tutorData['tutor_last_name']); ?>!</h2>
                        <?php else: ?>
                            <h1>Welcome, Tutor!</h1>
                        <?php endif; ?>
                            <p>Keep teaching students!</p>
                    </div>

                    <div class="user-info">
                    <img src="/images/tutor_uploads/tutor_profile_photos/<?= $tutorData['tutor_profile_photo']  ?>" alt="tutor profile photo" onerror="this.onerror=null; this.src='/images/tutor_uploads/tutor_profile_photos/default_tutor.png';">

                        <div class="user-info-text">
                            <p><b><?php echo htmlspecialchars($tutorData['tutor_first_name'] . ' ' . $tutorData['tutor_last_name']); ?></b></p>
                            <p><?php echo htmlspecialchars($tutorData['tutor_email'])?></p>
                        </div>
                    </div>
                    </div>
                    <div>

                    <div class="calendar">
                        <div class="calendar-header">
                            <button id="prev" class="nav-button">&lt;</button>
                            <div id="monthYear"></div>
                            <button id="next" class="nav-button">&gt;</button>
                        </div>
                        <div class="calendar-body">
                            <div class="day-names">
                                <span>Sun</span>
                                <span>Mon</span>
                                <span>Tue</span>
                                <span>Wed</span>
                                <span>Thu</span>
                                <span>Fri</span>
                                <span>Sat</span>
                            </div>
                            <div id="days" class="days"></div>
                        </div>
                        <div class="calendar-footer">
                            <span>Ends</span>
                            <input type="time" value="08:00" />
                        </div>
                        <script src="js/tutor/calendar.js"></script>
                    </div>
              
                
                <!--
                <div class="dashboard-container">
                    <div class="status-card finished-classes">
                      <h3>Classes Finished</h3>
                      <p id="finishedCount">10</p>
                    </div>
                    <div class="status-card upcoming-classes">
                      <h3>Upcoming Classes</h3>
                      <p id="upcomingCount">5</p>
                    </div>
                    <div class="status-card suspended-classes">
                      <h3>Classes Suspended</h3>
                      <p id="suspendedCount">2</p>
                    </div>
                </div>
                -->

            
            <div id="notifications" class="notifications">
                
            </div>

           
            <div id="rating">
                <span class="rating-text">Overall Rating </span>
                <div class="stars" id="starContainer">
                    
                </div>
                <span class="rating-number"> <?= isset($tutorRating) && $tutorRating !== null ? $tutorRating : '0' ?></span>

            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    function updateStarRating(rating) {
                        const maxStars = 5;
                        const starContainer = document.getElementById("starContainer");

                        if (!starContainer) return;

                        starContainer.innerHTML = ""; 

                        for (let i = 1; i <= maxStars; i++) {
                            const star = document.createElement("span");
                            star.classList.add("star");

                            if (i <= Math.floor(rating)) {
                                star.classList.add("filled"); 
                                star.innerHTML = "&#9733;";
                            } else if (i === Math.ceil(rating) && rating % 1 !== 0) {
                                star.classList.add("half-filled");
                                star.innerHTML = "&#9733;";
                            } else {
                                star.innerHTML = "&#9733;"; 
                            }

                            starContainer.appendChild(star);
                        }
                    }

                    
                    const tutorRating = parseFloat(
                        document.querySelector(".rating-number").textContent
                    );

                    if (!isNaN(tutorRating)) {
                        updateStarRating(tutorRating);
                    }
                });


            </script>
                    
                    
                <div id="payment">
                    <span class="payment-text">Recievables </span>
                    <span class="amount" id="paymentAmount">
                        <?= isset($tutorData['tutor_points']) && $tutorData['tutor_points'] !== null ? htmlspecialchars($tutorData['tutor_points']) : '0' ?> Points
                    </span>
                    
                </div>

            <!--<div class="carousel-container">
                <div class="carousel">
                    <div class="carousel-item"><img src="/images/user1.jpeg" alt="Image 1"></div>
                    <div class="carousel-item"><img src="/images/user2.jpeg" alt="Image 2"></div>
                    <div class="carousel-item"><img src="/images/user3.jpeg" alt="Image 3"></div>
                </div>
                <button class="carousel-btn prev-btn">&#10094;</button>
                <button class="carousel-btn next-btn">&#10095;</button>
            </div>
            <script src="carousel.js"></script>-->

            
                <div class="event-feedback-container">
                    <div class="events-section">
                        <h2>Upcoming Events</h2>
                        <a href="/tutor-event" class="view-all">View All</a>
                        <ul class="event-list">
                            <?php if (!empty($upcomingEvents)): ?>
                                <?php foreach (array_slice($upcomingEvents, 0, 3) as $event): ?>
                                    <li class="event-item">
                                        <div><?php echo htmlspecialchars($event['subject_name']); ?></div>
                                        <div><?php echo htmlspecialchars($event['student_first_name'] . ' ' . $event['student_last_name']); ?></div>
                                        <div><?php echo date('d M Y', strtotime($event['scheduled_date'])); ?></div>
                                        <div><?php echo date('h.i a', strtotime($event['schedule_time'])); ?></div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="event-item">No upcoming events available.</li>
                            <?php endif; ?>
                        </ul>

                        <h2>Previous Events</h2>
                        <ul class="event-list">
                            <?php if (!empty($previousEvents)): ?>
                                <?php foreach (array_slice($previousEvents, 0, 3) as $event): ?>
                                    <li class="event-item">
                                        <div><?php echo htmlspecialchars($event['subject_name']); ?></div>
                                        <div><?php echo htmlspecialchars($event['student_first_name'] . ' ' . $event['student_last_name']); ?></div>
                                        <div><?php echo date('d M Y', strtotime($event['scheduled_date'])); ?></div>
                                        <div><?php echo date('h.i a', strtotime($event['schedule_time'])); ?></div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="event-item">No previous events available.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                

                

                <div class="feedback"> 
                    <h2>Students' Feedback</h2>
                    <a href="/tutor-feedback" class="view-all">View All</a>
                    <ul class="feedback-list">
                        <?php if (!empty($tutorFeedback)): ?>
                            <?php foreach (array_slice($tutorFeedback, 0, 3) as $feedback): ?>
                                <li>
                                    <img src="/images/student-uploads/profilePhotos/<?= $feedback['student_profile_photo'] ?>" alt="User Image" class="feedback-img" onerror="this.onerror=null; this.src='/images/student-uploads/profilePhotos/default.jpg';">
                                    -<?= htmlspecialchars($feedback['student_name']); ?>-<br>
                                    <?= htmlspecialchars($feedback['student_feedback']); ?><br>
                                    <?= date('d M Y - h:i A', strtotime($feedback['time_created'])); ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No feedback available.</li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
