document.getElementById('upcoming-tab').addEventListener('click', function() {
    document.getElementById('upcoming-tab').classList.add('active');
    document.getElementById('previous-tab').classList.remove('active');
    document.getElementById('upcoming-content').classList.add('active');
    document.getElementById('previous-content').classList.remove('active');
});

document.getElementById('previous-tab').addEventListener('click', function() {
    document.getElementById('previous-tab').classList.add('active');
    document.getElementById('upcoming-tab').classList.remove('active');
    document.getElementById('previous-content').classList.add('active');
    document.getElementById('upcoming-content').classList.remove('active');
});
