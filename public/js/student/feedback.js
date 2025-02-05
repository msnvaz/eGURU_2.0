// Data
const tutors = [
    {
        id: 1,
        name: "Mr. Kavinda",
        subject: "Mathematics",
        image: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400"
    },
    {
        id: 2,
        name: "Mr. Dulanjaya",
        subject: "Science",
        image: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400"
    },
    {
        id: 3,
        name: "Mr. Nuwan",
        subject: "English",
        image: "https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=400"
    },
    {
        id: 4,
        name: "Mr. Lahiru",
        subject: "History",
        image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400"
    },
    {
        id: 5,
        name: "Ms. Chathuri",
        subject: "Geography",
        image: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400"
    }
];

// Feedback data stored in memory
let feedbackData = [
    {
        id: 1,
        tutorId: 1,
        rating: 5,
        text: "Excellent teaching methods!",
        date: "2024-03-15"
    },
    {
        id: 2,
        tutorId: 2,
        rating: 4,
        text: "Very helpful and patient.",
        date: "2024-03-14"
    }
];

let currentRating = 0;
let selectedTutorId = null;
let editingFeedbackId = null;

// DOM Elements
const tutorList = document.getElementById('tutorList');
const feedbackList = document.getElementById('feedbackList');
const modal = document.getElementById('feedbackModal');
const closeModal = document.getElementById('closeModal');
const feedbackForm = document.getElementById('feedbackForm');
const starRating = document.getElementById('starRating');

// Initialize
function init() {
    renderTutors();
    renderFeedback();
    setupEventListeners();
}

// Render Tutors
function renderTutors() {
    tutorList.innerHTML = tutors.map(tutor => `
        <div class="tutor-card">
            <img src="${tutor.image}" alt="${tutor.name}" class="tutor-image">
            <div class="tutor-info">
                <h3 class="tutor-name">${tutor.name}</h3>
                <p class="tutor-subject">${tutor.subject}</p>
                <button class="feedback-btn" data-tutor-id="${tutor.id}">
                    Give Feedback
                </button>
            </div>
        </div>
    `).join('');
}

// Render Feedback
function renderFeedback() {
    feedbackList.innerHTML = feedbackData.map(item => {
        const tutor = tutors.find(t => t.id === item.tutorId);
        return `
            <div class="feedback-item" data-feedback-id="${item.id}">
                <div class="feedback-header">
                    <strong>${tutor.name}</strong>
                    <span class="feedback-rating">${'★'.repeat(item.rating)}</span>
                </div>
                <p class="feedback-text">${item.text}</p>
                <p class="feedback-date">${new Date(item.date).toLocaleDateString()}</p>
                <div class="feedback-actions">
                    <button class="edit-btn" onclick="editFeedback('${item.id}')">Edit</button>
                    <button class="delete-btn" onclick="showDeleteConfirmation('${item.id}')">Delete</button>
                </div>
            </div>
        `;
    }).join('');
}

// Edit Feedback
function editFeedback(feedbackId) {
    console.log('hello')
    const feedback = feedbackData.find(f => f.id == feedbackId);
    if (!feedback) return;

    editingFeedbackId = feedbackId;
    selectedTutorId = feedback.tutorId;
    currentRating = feedback.rating;

    // Update form
    feedbackForm.feedback.value = feedback.text;
    // Show modal
    modal.style.display = 'flex';
    document.querySelector('.modal-header h3').textContent = 'Edit Feedback';
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

function openfeedback(tutorid) {
    const tutor = tutors.find(f => f.id == tutorid);
    const form = document.getElementById('feedbackForm')
    form.elements.tutor_id.value = tutorid
    form.elements.tutor_name.value = tutor.name
}

// Event Listeners
function setupEventListeners() {
    // Open modal for new feedback
    tutorList.addEventListener('click', (e) => {
        if (e.target.classList.contains('feedback-btn')) {
            editingFeedbackId = null;
            selectedTutorId = parseInt(e.target.dataset.tutorId);
            document.querySelector('.modal-header h3').textContent = 'Submit Feedback';
            modal.style.display = 'flex';
        }
    });

    // Close modal
    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
        resetForm();
    });

    // Click outside modal
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            resetForm();
        }
    });



}

// Update star rating display


// Reset form
function resetForm() {
    feedbackForm.reset();
    currentRating = 0;
    selectedTutorId = null;
    editingFeedbackId = null;
    updateStarRating();
}

// Initialize the application
document.addEventListener('DOMContentLoaded', init);