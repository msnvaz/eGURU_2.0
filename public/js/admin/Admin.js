// Message search functionality
document.getElementById('messageSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const messageCards = document.querySelectorAll('.message-card');
    
    messageCards.forEach(card => {
        const subject = card.querySelector('.message-subject').textContent.toLowerCase();
        const preview = card.querySelector('.message-preview').textContent.toLowerCase();
        const sender = card.querySelector('.sender-name').textContent.toLowerCase();
        
        if (subject.includes(searchTerm) || preview.includes(searchTerm) || sender.includes(searchTerm)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
});

// Modal functionality
function viewMessage(messageId) {
    const modal = document.getElementById('messageModal');
    modal.style.display = 'block';
    
    // Here you would typically fetch the full message details using AJAX
    // and populate the modal-body
}

// Close modal when clicking the X
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('messageModal').style.display = 'none';
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    const modal = document.getElementById('messageModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
});

function flagMessage(messageId) {
    // Add your flagging logic here
    console.log('Flagging message:', messageId);
}

function deleteMessage(messageId) {
    if (confirm('Are you sure you want to delete this message?')) {
        // Add your delete logic here
        console.log('Deleting message:', messageId);
    }
}

// Filter functionality
document.querySelectorAll('.filter-select').forEach(select => {
    select.addEventListener('change', function() {
        // Add your filter logic here
        console.log('Filter changed:', this.value);
    });
});

 // Toggle Dropdown
    
