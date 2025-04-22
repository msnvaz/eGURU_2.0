<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: /student-login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Tutor</title>
    <link rel="stylesheet" href="css/student/findtutor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    

    <div class="main-content">
        <div class="container">
        <a href="/student-dashboard" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Dashboard</span>
            </a>

            <h1 class="page-title">Find a Tutor</h1>
            
            <div class="welcome-section">
                <h2>Welcome to eGuru Tutoring</h2>
                <p>Find the perfect tutor to help you achieve your academic goals</p>
                
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <h3>Expert Tutors</h3>
                        <p>Connect with qualified and experienced tutors</p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Verified qualifications</li>
                            <li><i class="fas fa-check"></i> Years of experience</li>
                            <li><i class="fas fa-check"></i> Professional training</li>
                        </ul>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h3>All Subjects</h3>
                        <p>Find help in any subject you need</p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Mathematics</li>
                            <li><i class="fas fa-check"></i> Sciences</li>
                            <li><i class="fas fa-check"></i> Languages & More</li>
                        </ul>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3>Verified Quality</h3>
                        <p>Learn from top-rated tutoring professionals</p>
                        <ul class="feature-list">
                            <li><i class="fas fa-check"></i> Quality assured</li>
                            <li><i class="fas fa-check"></i> Student reviews</li>
                            <li><i class="fas fa-check"></i> Success tracking</li>
                        </ul>
                    </div>
                </div>
            </div>

            <form method="POST" action="/student-search-tutor" class="filter-form">
                <div class="filters-grid">
                    <div class="form-group">
                        <label for="grade">Grade:</label>
                        <select name="grade" id="grade">
                            <option value="">All Grades</option>
                            <?php foreach ($grades as $grade): ?>
                                <option value="<?= htmlspecialchars($grade['grade']) ?>"
                                        <?= isset($_POST['grade']) && $_POST['grade'] == $grade['grade'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($grade['grade']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <select name="subject" id="subject">
                            <option value="">All Subjects</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= htmlspecialchars($subject['subject_id']) ?>"
                                        <?= isset($_POST['subject']) && $_POST['subject'] == $subject['subject_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($subject['subject_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="experience">Experience Level:</label>
                        <select name="experience" id="experience">
                            <option value="">Any Experience</option>
                            <?php foreach ($experiences as $experience): ?>
                                <option value="<?= htmlspecialchars($experience['experience']) ?>"
                                        <?= isset($_POST['experience']) && $_POST['experience'] == $experience['experience'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($experience['experience']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="search-button">
                    <span class="search-icon">🔍</span>
                    Find Tutors
                </button>
            </form>

            <div class="tutor-results">
                <?php if (!empty($tutors)): ?>
                    <div class="tutors-grid">
                        <?php foreach ($tutors as $tutor): ?>
                            <div class="tutor-card">
                                <div class="tutor-header">
                                    <img class="tutor-profile-photo" 
                                         src="/images/tutor_uploads/tutor_profile_photos/<?= htmlspecialchars($tutor['tutor_profile_photo']) ?>" 
                                         alt="<?= htmlspecialchars($tutor['tutor_first_name']) ?>'s photo">
                                    <h2><?= htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']) ?></h2>
                                    <span class="tutor-level" style="background-color: <?= htmlspecialchars($tutor['tutor_level_color']) ?>">
                                        <?= htmlspecialchars($tutor['tutor_level']) ?>
                                    </span>
                                </div>
                                
                                <div class="tutor-details">
                                    <p><strong>Qualification:</strong> <?= htmlspecialchars($tutor['tutor_level_qualification']) ?></p>
                                    <p><strong>Subjects:</strong> <?= htmlspecialchars($tutor['subjects']) ?></p>
                                    <p><strong>Grades:</strong> <?= htmlspecialchars($tutor['grades']) ?></p>
                                </div>
                                
                                <div class="availability">
                                    <h3>Available Times</h3>
                                    <ul class="availability-list">
                                        <?php 
                                        $times = explode(',', $tutor['available_times']);
                                        foreach ($times as $time): 
                                            if (!empty(trim($time))):
                                        ?>
                                            <li class="availability-item"><?= htmlspecialchars(trim($time)) ?></li>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        ?>
                                    </ul>
                                </div>

                                <button class="request-button" 
                                        onclick="showRequestModal('<?= htmlspecialchars($tutor['tutor_id']) ?>', 
                                                                '<?= htmlspecialchars($tutor['tutor_first_name']) ?>')">
                                    Request Tutor
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
    <div class="no-results">
        <div class="no-results-content">
            
            <h3>Looking for the perfect match</h3>
            <p>We're here to help you find your ideal tutor. Try different search criteria to discover more options.</p>
        </div>
    </div>
<?php endif; ?>
            </div>

            <!-- Confirmation Modal -->
            <div id="requestModal" class="modal">
                <div class="modal-content">
                    <h2>Confirm Request</h2>
                    <p>Would you like to request <span id="tutorName"></span> as your tutor?</p>
                    <div class="modal-buttons">
                        <button class="modal-confirm" onclick="confirmRequest()">Confirm</button>
                        <button class="modal-cancel" onclick="hideRequestModal()">Cancel</button>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            <div id="successMessage" class="success-message">
                Request sent successfully!
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="error-message">
                <!-- Error message will be inserted here -->
            </div>
        </div>
    </div>

    <script src="js/student/findtutor.js"></script>
</body>
</html>