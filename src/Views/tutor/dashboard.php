<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php?action=login");
    exit();
}

$userEmail = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/footer.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php include '../src/Views/navbar.php'; ?>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>e-Guru</h2>
            <ul>
                <li><i class="fa-solid fa-table-columns"></i><a href="tutor-dashboard">Dashboard</a></li>
                <li><i class="fa-solid fa-calendar-days"></i><a href="tutor-event">Events</a></li>
                <li><i class="fa-solid fa-comment"></i><a href="tutor-request">Student Requests</a></li>
                <li><i class="fa-solid fa-user"></i><a href="tutor-public-profile">Public profile</a></li>
                <li><i class="fa-solid fa-star"></i><a href="tutor-feedback">Student Feeback</a></li>
                <li><i class="fa-solid fa-rectangle-ad"></i><a href="tutor-advertisement"> Advertisement</a></li>
                <li><i class="fa-solid fa-right-from-bracket"></i><a href="tutor-logout"> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Navbar -->
            <!-- <nav class="nav-bar">
                <a href="#">Home</a>
                <a href="#">How it works</a>
                <a href="#">Reviews</a>
                <a href="#">Tutors</a>
                <a href="#">Subjects</a>
                <a href="#">Search</a>
                <a href="#">Forum</a>
                <a href="#">About</a>
                <a href="#" class="active">My Profile</a>
            </nav> -->

            <!-- Profile Info, User Info, and Calendar on the Same Level -->
            <div class="profile-info-container">
                <div class="profile-info">
                    <div class="welcome">
                        <h2>Welcome back, Mr. Kavindha</h2>
                        <p>Keep teaching students!</p>
                    </div>

                    <div class="user-info">
                        <img src="\images\review\review3.jpeg" alt="Mr. Kavindha" width="100" height="100">
                        <div class="user-info-text">
                            <p>Mr. Kavindha</p>
                            <p>kavindha123@gmail.com</p>
                            
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


            <!-- Below the Profile Info, User Info, and Calendar -->
            <div id="notifications" class="notifications">
                <!-- Notifications will be added here -->
            </div>

            <div id="rate_payment">
                <div id="rating">
                    <span class="rating-text">Overall Rating: </span>
                    <div class="stars">
                      <span class="star filled">&#9733;</span> <!-- Filled star -->
                      <span class="star filled">&#9733;</span> <!-- Filled star -->
                      <span class="star filled">&#9733;</span> <!-- Filled star -->
                      <span class="star filled">&#9733;</span> <!-- Filled star -->
                      <span class="star">&#9733;</span> <!-- Empty star -->
                    </div>
                    <span class="rating-number">4.0/5</span> <!-- Display the rating value -->
                </div>

                <div id="payment">
                    <span class="payment-text">Recievables: </span>
                    <span class="amount" id="paymentAmount">2000 Points</span>
                    <script src="/js/tutor/payment.js"></script>
                </div>
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

            <!-- Events and Feedback -->
            <div class="event-feedback-container">
                <div class="events-section">
                    <h2>Upcoming Events</h2>
                    <a href="#" class="view-all">View All</a>
                    <ul class="event-list">
                        <li class="event-item">
                            <div>Mathematics</div>
                            <div>Mr. James Anderson</div>
                            <div>20 Aug 2024</div>
                            <div>2.00 pm</div>
                        </li>
                        <li class="event-item">
                            <div>Science</div>
                            <div>Mr. James Anderson</div>
                            <div>20 Aug 2024</div>
                            <div>2.00 pm</div>
                        </li>
                        <li class="event-item">
                            <div>English</div>
                            <div>Mr. James Anderson</div>
                            <div>20 Aug 2024</div>
                            <div>2.00 pm</div>
                        </li>
                    </ul>

                    <h2>Previous Events</h2>
                    <a href="#" class="view-all">View All</a>
                    <ul class="event-list">
                        <li class="event-item">
                            <div>Mathematics</div>
                            <div>Mr. James Anderson</div>
                            <div>20 Aug 2024</div>
                            <div>2.00 pm</div>
                        </li>
                        <li class="event-item">
                            <div>Science</div>
                            <div>Mr. James Anderson</div>
                            <div>20 Aug 2024</div>
                            <div>2.00 pm</div>
                        </li>
                        <li class="event-item">
                            <div>English</div>
                            <div>Mr. James Anderson</div>
                            <div>20 Aug 2024</div>
                            <div>2.00 pm</div>
                        </li>
                    </ul>
                </div>

                <div class="feedback">
                    <h2>Students' Feedback</h2>
                    <a href="#" class="view-all">View All</a>
                    <ul class="feedback-list">
                        <li>
                            <img src="/images/user1.jpeg" alt="User Image" class="feedback-img">
                            Thank you for your wonderful session Sir!!<br>15 Aug 2024 - 4.50 pm
                        </li>
                        <li>
                            <img src="/images/user2.jpeg" alt="User Image" class="feedback-img">
                            Enough Explanation!! Give more exercises!!<br>15 Aug 2024 - 4.50 pm
                        </li>
                        <li>
                            <img src="/images/user3.jpeg" alt="User Image" class="feedback-img">
                            Need some practical go-through<br>15 Aug 2024 - 4.50 pm
                        </li>
                        <li>
                            <img src="/images/user4.jpeg" alt="User Image" class="feedback-img">
                            Need some practical go-through<br>15 Aug 2024 - 4.50 pm
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
