<!DOCTYPE html>
<html lang="en">

<?php $page = "feedback"?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Feedback System</title>
    <link rel="stylesheet" href="css/student/feedback.css">
    <link rel="stylesheet" href="css/student/new.css">
</head>

<body>
<?php include '../src/Views/navbar.php'; ?>
        <div class="container">
        <?php include 'sidebar.php'; ?>
        <header class="header">
            <h1>Tutor Feedback </h1>
            <p class="subtitle">Share your learning experience</p>
        </header>

        <main class="main-content">
            <section class="tutors-section">
                <h2>Your Tutors</h2>
                <div class="tutor-grid" id="tutorList"></div>
            </section>

            <section class="feedback-section">
                <h2>Recent Feedback</h2>
                <div class="feedback-list" id="feedbackList"></div>
            </section>
        </main>

        <!-- Feedback Modal -->
        <div class="modal" id="feedbackModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Submit Feedback</h3>
                    <button class="close-btn" id="closeModal" onclick="closemodel()">&times;</button>
                </div>
                <form id="feedbackForm" class="feedback-form" method="post" action="feedback/submit">
                    <input type="hidden" id="tutorId" name="tutor_id">
                    <input type="hidden" id="tutorId" name="tutor_name">
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <label for="feedback">Your Feedback</label>
                        <textarea id="feedback" name="comments" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Submit Feedback</button>
                </form>
            </div>
        </div>


        <div class="modal" id="feedbackModal1">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Edit your Feedback</h3>
                    <button class="close-btn" id="closeModal1" onclick="closemodel1()">&times;</button>
                </div>
                <form id="feedbackeditForm" class="feedback-form" method="post" action="feedback/edit">
                    <input type="hidden" id="tutorId" name="id">
                    <div class="form-group">
                    </div>
                    <div class="form-group">
                        <label for="feedback">Your Feedback</label>
                        <textarea id="feedback" name="comments" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Save Feedback</button>
                </form>
            </div>
        </div>
        </div>
        <script>
            const tutors = [{
                    id: 1,
                    name: "Mr. Kavinda",
                    subject: "Mathematics",
                    image: "images/student-uploads/tutor1.jpg"
                },
                {
                    id: 2,
                    name: "Mr. Dulanjaya",
                    subject: "Science",
                    image: "images/student-uploads/tutor2.jpg"
                },
                {
                    id: 3,
                    name: "Mr. Nuwan",
                    subject: "English",
                    image: "images/student-uploads/tutor3.jpg"
                },
                {
                    id: 4,
                    name: "Mr. Lahiru",
                    subject: "History",
                    image: "images/student-uploads/tutor4.jpg"
                },
                {
                    id: 5,
                    name: "Mr. Chamath",
                    subject: "Geography",
                    image: "images/student-uploads/tutor5.jpg"
                }
            ];

            // Feedback data stored in memory
            let feedbackData = <?php echo json_encode($data) ?>;

            // DOM Elements
            const tutorList = document.getElementById('tutorList');
            const feedbackList = document.getElementById('feedbackList');
            const modal = document.getElementById('feedbackModal');
            const modal1 = document.getElementById('feedbackModal1');
            const editmodal = document.getElementById('feedbackModal1');
            const closeModal = document.getElementById('closeModal');
            const closeModal1 = document.getElementById('closeModal1');
            const feedbackForm = document.getElementById('feedbackForm');

            // Initialize
            function init() {
                renderTutors();
                renderFeedback();
            }

            // Render Tutors
            function renderTutors() {
                tutorList.innerHTML = tutors.map(tutor => `
        <div class="tutor-card">
            <img src="${tutor.image}" alt="${tutor.name}" class="tutor-image">
            <div class="tutor-info">
                <h3 class="tutor-name">${tutor.name}</h3>
                <p class="tutor-subject">${tutor.subject}</p>
               <button class="feedback-btn" onclick="openfeedback('${tutor.id}')" data-tutor-id="${tutor.id}">Give Feedback</button>
                </button>
            </div>
        </div>
    `).join('');
            }

            // Render Feedback
            function renderFeedback() {
                feedbackList.innerHTML = feedbackData.map(item => {
                    return `
            <div class="feedback-item" data-feedback-id="${item.id}">
                <div class="feedback-header">
                    <strong>${item.tutor_name}</strong>
                </div>
                <p class="feedback-text">${item.comments}</p>

                <div class="feedback-actions">
                    <button class="edit-btn" onclick="editFeedback('${item.id}')">Edit</button>
                    <form method ="post" action="feedback/delete">
                    <input type="hidden" name="id" value="${item.id}">
                    <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </div>
            </div>
        `;
                }).join('');
            }

            // Edit Feedback
            function editFeedback(feedbackId) {
                const feedback = feedbackData.find(item => item.id == feedbackId);
                console.log(feedback);
                modal1.style.display = 'flex';
                const editform = document.getElementById('feedbackeditForm');
                editform.elements.id.value = feedbackId;
                editform.elements.comments.value = feedback.comments;
            }

            function closemodel1(){
                modal1.style.display = 'none';
            }

            function closemode(){
                modal.style.display = 'none';
            }

            // Delete Feedback
            function showDeleteConfirmation(feedbackId) {
                if (confirm('Are you sure you want to delete this feedback?')) {
                    deleteFeedback(feedbackId);
                }
            }

            function deleteFeedback(feedbackId) {
                feedbackData = feedbackData.filter(f => f.id !== feedbackId);
                renderFeedback();
            }

            // // Event Listeners
            // function setupEventListeners() {
            //     // Open modal for new feedback
            //     tutorList.addEventListener('click', (e) => {
            //         if (e.target.classList.contains('feedback-btn')) {
            //             editingFeedbackId = null;
            //             selectedTutorId = parseInt(e.target.dataset.tutorId);
            //             document.querySelector('.modal-header h3').textContent = 'Submit Feedback';
            //             modal.style.display = 'flex';
            //         }
            //     });

            //     // Close modal
            //     closeModal.addEventListener('click', () => {
            //         modal.style.display = 'none';
            //         resetForm();
            //     });

                // Click outside modal
                // window.addEventListener('click', (e) => {
                //     if (e.target === modal) {
                //         modal.style.display = 'none';
                //         resetForm();
                //     }
                // });



            // Update star rating display


            // Reset form
            function resetForm() {
                feedbackForm.reset();
                currentRating = 0;
                selectedTutorId = null;
                editingFeedbackId = null;
                updateStarRating();
            }

            function openfeedback(tutorid){
                console.log("hello");
                const tutor = tutors.find(f => f.id == tutorid);
                const form = document.getElementById('feedbackForm')
                form.elements.tutor_id.value = tutorid
                form.elements.tutor_name.value = tutor.name
                modal.style.display = "flex";
            }

            

            // Initialize the application
            document.addEventListener('DOMContentLoaded', init);
</script>

<!-- <script src="js/student/feedback.js"></script> -->

</body>

</html>