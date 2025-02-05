function toggleRequests(type) {
    const pastCurrentTab = document.getElementById('past-current-tab');
    const newTab = document.getElementById('new-tab');
    const pastCurrentRequests = document.getElementById('past-current-requests');
    const newRequests = document.getElementById('new-requests');

    if (type === 'past-current') {
        pastCurrentTab.classList.add('active');
        newTab.classList.remove('active');
        pastCurrentRequests.style.display = 'block';
        newRequests.style.display = 'none';
    } else {
        newTab.classList.add('active');
        pastCurrentTab.classList.remove('active');
        newRequests.style.display = 'block';
        pastCurrentRequests.style.display = 'none';
    }
}
