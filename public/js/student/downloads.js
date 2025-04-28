function loadMaterials() {
    const tutorId = document.getElementById('tutor').value;
    const subjectId = document.getElementById('subject').value;
    const materialContainer = document.getElementById('materialContainer');

    
    materialContainer.innerHTML = '<div class="loading">Loading materials...</div>';

    const xhr = new XMLHttpRequest();
    xhr.open('GET', `/student-downloads/filter?tutor_id=${encodeURIComponent(tutorId)}&subject_id=${encodeURIComponent(subjectId)}`, true);

    xhr.onload = function() {
        if (this.status === 200) {
            materialContainer.innerHTML = this.responseText;
            
            materialContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            materialContainer.innerHTML = '<div class="error">Error loading materials. Please try again.</div>';
        }
    };

    xhr.onerror = function() {
        materialContainer.innerHTML = '<div class="error">Error loading materials. Please try again.</div>';
    };

    xhr.send();
}