<!DOCTYPE html>
<html lang="en">

<?php $page = "feedback"?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Feedback </title>
    <link rel="stylesheet" href="css/student/feedback.css">
    <link rel="stylesheet" href="css/student/new.css">
    
    <link rel="stylesheet" href="css/student/sidebar.css">
    <style>
        
        .container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            padding: 1rem;
        }
        
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
        }
        
        .feedback_header {
            text-align: center;
            padding: 2.3rem 0;
            background-color: #f8f9fa;
            margin-bottom: 4rem;
            margin-left: 150px;
            width: 96.5%;
        }
        
        .feedback_header h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .subtitle {
            color: #6c757d;
        }
        
        .tutors-section, .feedback-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }
        
        .tutors-section h2, .feedback-section h2 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }
        
        .tutor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
        }
        
        .tutor-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .tutor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .tutor-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1rem;
            border: 3px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .tutor-name {
            font-size: 1.1rem;
            margin-bottom: 0.3rem;
        }
        
        .tutor-subject {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .feedback-btn {
            background-color: #E14177;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
            width: 100%;
        }
        
        .feedback-btn:hover {
            background-color: #e02362;
        }
        
        .feedback-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .feedback-item {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1rem;
            background-color: #f8f9fa;
        }
        
        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .feedback-text {
            margin-bottom: 1rem;
            color: #333;
        }
        
        .feedback-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
        }
        
        .edit-btn, .delete-btn {
            padding: 0.3rem 0.8rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .edit-btn {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .delete-btn {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .edit-btn:hover {
            background-color: #dee2e6;
        }
        
        .delete-btn:hover {
            background-color: #f5c6cb;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-content {
            background-color: white;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #aaa;
        }
        
        .close-btn:hover {
            color: #333;
        }
        
        .feedback-form {
            padding: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #495057;
        }
        
        .rating-group {
            display: flex;
            gap: 0.5rem;
        }
        
        .star-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: #ccc;
        }
        
        .star-btn.active {
            color: #ffc107;
        }
        
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            resize: vertical;
        }
        
        .submit-btn {
            background-color: #E14177 ;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0.75rem 1.5rem;
            cursor: pointer;
            float: right;
        }
        
        .submit-btn:hover {
            background-color: #e02362;
        }
        
        .tutor-reply {
            background-color: #e9f5ff;
            border-radius: 4px;
            padding: 0.75rem;
            margin-top: 0.75rem;
        }
        
        .tutor-reply-header {
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #0056b3;
        }
        
        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.25rem;
            text-align: center;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            margin-left: 150px;
            margin-bottom: 80px;
            margin-top: 2px;
            width: 96.5%;
        }
        
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            margin-left: 150px;
            margin-bottom: 80px;
            margin-top: 2px;
            width: 96.5%;
        }
        
        .star-rating {
            display: flex;
            gap: 2px;
        }
        
        .star {
            color: #ffc107;
        }
        
        .star-empty {
            color: #e4e5e9;
        }
    </style>
</head>

<body>
<?php include '../src/Views/student/header.php'; ?>
    <div class="container">
        <?php include 'sidebar.php'; ?>
        
        <header class="feedback_header">
            <h1>Tutor Feedback</h1>
            <p class="subtitle">Share your learning experience with tutors</p>
        </header>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <main class="main-content">
            <section class="tutors-section">
                <h2>Tutors with Completed Sessions</h2>
                
                <?php if (empty($tutors)): ?>
                    <p>No tutors with completed sessions found.</p>
                <?php else: ?>
                    <div class="tutor-grid">
                        <?php foreach ($tutors as $tutor): ?>
                            <div class="tutor-card">
                                <img 
                                    src="/images/tutor_uploads/tutor_profile_photos/<?php echo htmlspecialchars($tutor['tutor_profile_photo']); ?>" 
                                    alt="<?php echo htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']); ?>" 
                                    class="tutor-image"
                                    
                                >
                                <h3 class="tutor-name">
                                    <?php echo htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']); ?>
                                </h3>
                                <p class="tutor-subject">
                                    <?php echo htmlspecialchars($tutor['subject_name']); ?>
                                </p>
                                <button 
                                    class="feedback-btn" 
                                    onclick="openFeedbackModal(<?php echo $tutor['tutor_id']; ?>, '<?php echo htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']); ?>', <?php echo $tutor['session_id']; ?>)"
                                >
                                    Give Feedback
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

            <section class="feedback-section">
                <h2>Your Feedback</h2>
                
                <?php if (empty($feedbacks)): ?>
                    <p>You haven't provided any feedback yet.</p>
                <?php else: ?>
                    <div class="feedback-list">
                        <?php foreach ($feedbacks as $feedback): ?>
                      
<div class="feedback-item">
    <div class="feedback-header">
        <strong>
            <?php echo htmlspecialchars($feedback['tutor_first_name'] . ' ' . $feedback['tutor_last_name']); ?>
        </strong>
        <div class="star-rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <?php if ($i <= $feedback['session_rating']): ?>
                    <span class="star">★</span>
                <?php else: ?>
                    <span class="star-empty">★</span>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
    
    <p class="feedback-text">
        <?php echo htmlspecialchars($feedback['student_feedback']); ?>
    </p>
    
    <div class="feedback-timestamps">
        <small class="text-gray-500">
            Created: <?php echo date('M j, Y g:i A', strtotime($feedback['time_created'])); ?>
            <?php if ($feedback['last_updated'] !== $feedback['time_created']): ?>
                | Updated: <?php echo date('M j, Y g:i A', strtotime($feedback['last_updated'])); ?>
            <?php endif; ?>
        </small>
    </div>
    
    <?php if ($feedback['tutor_reply']): ?>
        <div class="tutor-reply">
            <div class="tutor-reply-header">Tutor Reply:</div>
            <p><?php echo htmlspecialchars($feedback['tutor_reply']); ?></p>
        </div>
    <?php endif; ?>
    
    <div class="feedback-actions">
        <button 
            class="edit-btn" 
            onclick="openEditFeedbackModal(
                <?php echo $feedback['feedback_id']; ?>, 
                '<?php echo htmlspecialchars($feedback['student_feedback']); ?>', 
                <?php echo $feedback['session_rating']; ?>
            )"
        >
            Edit
        </button>
        
        <form method="post" action="/student-feedback/delete" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
            <input type="hidden" name="feedback_id" value="<?php echo $feedback['feedback_id']; ?>">
            <button type="submit" class="delete-btn">Delete</button>
        </form>
    </div>
</div>

                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </main>

        
        <div class="modal" id="feedbackModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Submit Feedback</h3>
                    <button class="close-btn" onclick="closeModal('feedbackModal')">&times;</button>
                </div>
                
                <form id="feedbackForm" class="feedback-form" method="post" action="/student-feedback/submit">
                    <input type="hidden" id="session_id" name="session_id">
                    
                    <div class="form-group">
                        <p id="tutorName" class="text-center font-medium"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="session_rating">Rating</label>
                        <div class="rating-group">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <button 
                                    type="button" 
                                    class="star-btn" 
                                    data-rating="<?php echo $i; ?>" 
                                    onclick="setRating(<?php echo $i; ?>)"
                                >
                                    ★
                                </button>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" id="session_rating" name="session_rating" value="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="student_feedback">Your Feedback</label>
                        <textarea 
                            id="student_feedback" 
                            name="student_feedback" 
                            rows="4" 
                            required
                        ></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Submit Feedback</button>
                </form>
            </div>
        </div>

        
        <div class="modal" id="editFeedbackModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Edit Feedback</h3>
                    <button class="close-btn" onclick="closeModal('editFeedbackModal')">&times;</button>
                </div>
                
                <form id="editFeedbackForm" class="feedback-form" method="post" action="/student-feedback/update">
                    <input type="hidden" id="edit_feedback_id" name="feedback_id">
                    
                    <div class="form-group">
                        <label for="edit_session_rating">Rating</label>
                        <div class="rating-group" id="editRatingGroup">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <button 
                                    type="button" 
                                    class="star-btn" 
                                    data-rating="<?php echo $i; ?>" 
                                    onclick="setEditRating(<?php echo $i; ?>)"
                                >
                                    ★
                                </button>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" id="edit_session_rating" name="session_rating" value="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_student_feedback">Your Feedback</label>
                        <textarea 
                            id="edit_student_feedback" 
                            name="student_feedback" 
                            rows="4" 
                            required
                        ></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Update Feedback</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        
        function openFeedbackModal(tutorId, tutorName, sessionId) {
            document.getElementById('session_id').value = sessionId;
            document.getElementById('tutorName').textContent = tutorName;
            document.getElementById('feedbackModal').style.display = 'flex';
            
           
            document.getElementById('feedbackForm').reset();
            document.getElementById('session_rating').value = 0;
            updateStarRating(0);
        }
        
        
        function openEditFeedbackModal(feedbackId, feedback, rating) {
            document.getElementById('edit_feedback_id').value = feedbackId;
            document.getElementById('edit_student_feedback').value = feedback;
            document.getElementById('edit_session_rating').value = rating;
            document.getElementById('editFeedbackModal').style.display = 'flex';
            
            
            updateEditStarRating(rating);
        }
        
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        
        function setRating(rating) {
            document.getElementById('session_rating').value = rating;
            updateStarRating(rating);
        }
        
        
        function setEditRating(rating) {
            document.getElementById('edit_session_rating').value = rating;
            updateEditStarRating(rating);
        }
        
        
        function updateStarRating(rating) {
            const stars = document.querySelectorAll('#feedbackForm .star-btn');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                    star.style.color = '#ffc107';
                } else {
                    star.classList.remove('active');
                    star.style.color = '#ccc';
                }
            });
        }
        
        
        function updateEditStarRating(rating) {
            const stars = document.querySelectorAll('#editFeedbackForm .star-btn');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                    star.style.color = '#ffc107';
                } else {
                    star.classList.remove('active');
                    star.style.color = '#ccc';
                }
            });
        }
        
        
        window.addEventListener('click', function(event) {
            const feedbackModal = document.getElementById('feedbackModal');
            const editFeedbackModal = document.getElementById('editFeedbackModal');
            
            if (event.target === feedbackModal) {
                feedbackModal.style.display = 'none';
            }
            
            if (event.target === editFeedbackModal) {
                editFeedbackModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>