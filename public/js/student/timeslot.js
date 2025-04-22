// Check if there's a success message in URL parameters
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        showModal('successModal');
        // Remove the parameter from URL without reloading the page
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    } else if (urlParams.has('error')) {
        const errorMsg = urlParams.get('error') || 'There was an error saving your time slots.';
        document.getElementById('errorMessage').textContent = errorMsg;
        showModal('errorModal');
        // Remove the parameter from URL without reloading the page
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});

document.getElementById('editBtn').addEventListener('click', function() {
    // Enable all checkboxes
    const checkboxes = document.querySelectorAll('#timeslotForm input[type="checkbox"]');
    checkboxes.forEach(cb => cb.disabled = false);

    // Show the Save button
    document.getElementById('saveBtn').style.display = 'inline-block';

    // Hide the Edit button
    this.style.display = 'none';
});

// Show confirmation modal before submitting form
document.getElementById('timeslotForm').addEventListener('submit', function(e) {
    e.preventDefault();
    showModal('confirmModal');
});

// When user confirms in the modal, submit the form
document.getElementById('confirmSave').addEventListener('click', function() {
    document.getElementById('timeslotForm').submit();
    hideModal('confirmModal');
});

// Modal functions
function showModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function hideModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Event listeners for modal close buttons
const closeButtons = document.querySelectorAll('.close-modal, .close-modal-btn');
closeButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        const modal = this.closest('.modal');
        modal.style.display = 'none';
    });
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});