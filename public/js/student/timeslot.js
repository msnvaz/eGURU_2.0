
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        showModal('successModal');
        
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    } else if (urlParams.has('error')) {
        const errorMsg = urlParams.get('error') || 'There was an error saving your time slots.';
        document.getElementById('errorMessage').textContent = errorMsg;
        showModal('errorModal');
        
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});

document.getElementById('editBtn').addEventListener('click', function() {
    
    const checkboxes = document.querySelectorAll('#timeslotForm input[type="checkbox"]');
    checkboxes.forEach(cb => cb.disabled = false);

    
    document.getElementById('saveBtn').style.display = 'inline-block';

    
    this.style.display = 'none';
});


document.getElementById('timeslotForm').addEventListener('submit', function(e) {
    e.preventDefault();
    showModal('confirmModal');
});


document.getElementById('confirmSave').addEventListener('click', function() {
    document.getElementById('timeslotForm').submit();
    hideModal('confirmModal');
});


function showModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function hideModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}


const closeButtons = document.querySelectorAll('.close-modal, .close-modal-btn');
closeButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        const modal = this.closest('.modal');
        modal.style.display = 'none';
    });
});


window.addEventListener('click', function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});