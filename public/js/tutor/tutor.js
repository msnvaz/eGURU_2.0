// Get all sidebar links
document.querySelectorAll('.sidebar ul li a').forEach(link => {
    link.addEventListener('click', function () {
        // Remove 'active' class from all links
        document.querySelectorAll('.sidebar ul li a').forEach(el => el.classList.remove('active'));
        
        // Add 'active' class to the clicked link
        this.classList.add('active');
    });
});

// Add click event to each link and store clicked link ID in localStorage
document.querySelectorAll('.sidebar ul li a').forEach(link => {
    link.addEventListener('click', function () {
        // Remove 'active' class from all links
        document.querySelectorAll('.sidebar ul li a').forEach(el => el.classList.remove('active'));

        // Add 'active' class to the clicked link
        this.classList.add('active');

        // Store the clicked link's ID in localStorage
        localStorage.setItem('activeLink', this.id);
    });
});

// On page load, retrieve the active link from localStorage and add the 'active' class
document.addEventListener('DOMContentLoaded', () => {
    const activeLinkId = localStorage.getItem('activeLink');
    if (activeLinkId) {
        const activeLink = document.getElementById(activeLinkId);
        if (activeLink) {
            activeLink.classList.add('active');
        }
    }
});
