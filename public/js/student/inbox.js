document.addEventListener('DOMContentLoaded', function() {
    const messageSearch = document.getElementById('messageSearch');
    const senderFilter = document.querySelector('.filters select:first-child');
    const sortFilter = document.querySelector('.filters select:last-child');
    const messageCards = document.querySelectorAll('.message-card');

    
    messageSearch.addEventListener('input', filterMessages);
    senderFilter.addEventListener('change', filterMessages);
    sortFilter.addEventListener('change', sortMessages);

    function filterMessages() {
        const searchTerm = messageSearch.value.toLowerCase();
        const senderType = senderFilter.value;

        messageCards.forEach(card => {
            const senderBadge = card.querySelector('.sender-badge');
            const senderName = card.querySelector('.sender-name').textContent.toLowerCase();
            const subject = card.querySelector('.message-subject h3').textContent.toLowerCase();
            const preview = card.querySelector('.message-preview').textContent.toLowerCase();

            const matchesSearch = searchTerm === '' || 
                senderName.includes(searchTerm) || 
                subject.includes(searchTerm) || 
                preview.includes(searchTerm);

            const matchesSenderType = senderType === 'all' || 
                senderBadge.classList.contains(senderType);

            card.classList.toggle('hidden', !(matchesSearch && matchesSenderType));
        });
    }

    function sortMessages() {
        const sortType = sortFilter.value;
        const messagesGrid = document.querySelector('.messages-grid');
        const cards = Array.from(messageCards);

        switch(sortType) {
            case 'newest':
                cards.sort((a, b) => {
                    const dateA = new Date(a.querySelector('.message-time').textContent);
                    const dateB = new Date(b.querySelector('.message-time').textContent);
                    return dateB - dateA;
                });
                break;
            case 'oldest':
                cards.sort((a, b) => {
                    const dateA = new Date(a.querySelector('.message-time').textContent);
                    const dateB = new Date(b.querySelector('.message-time').textContent);
                    return dateA - dateB;
                });
                break;
            case 'priority':
                cards.sort((a, b) => {
                    const priorityA = a.classList.contains('high-priority') ? 1 : 0;
                    const priorityB = b.classList.contains('high-priority') ? 1 : 0;
                    return priorityB - priorityA;
                });
                break;
        }

        
        cards.forEach(card => messagesGrid.appendChild(card));
    }
});