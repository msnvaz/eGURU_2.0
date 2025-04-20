let selectedTutorId = null;

        function showRequestModal(tutorId, tutorName) {
            selectedTutorId = tutorId;
            document.getElementById('tutorName').textContent = tutorName;
            document.getElementById('requestModal').style.display = 'flex';
        }

        function hideRequestModal() {
            document.getElementById('requestModal').style.display = 'none';
        }

        function showSuccessMessage() {
            const successMessage = document.getElementById('successMessage');
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
        }

        function showErrorMessage(message) {
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message || 'Please try again. If the problem persists, contact support.';
            errorMessage.style.display = 'block';
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 5000);
        }

        function confirmRequest() {
            if (!selectedTutorId) {
                showErrorMessage('Invalid tutor selection. Please try again.');
                return;
            }

            const subjectSelect = document.getElementById('subject');
            const subjectId = subjectSelect.value;

            if (!subjectId) {
                showErrorMessage('Please select a subject before requesting a tutor.');
                return;
            }

            fetch('/student-request-tutor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    tutorId: selectedTutorId,
                    subjectId: subjectId
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Request failed with status ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                hideRequestModal();
                showSuccessMessage();
            })
            .catch(error => {
                console.error('Error:', error);
                showErrorMessage('Unable to send request at this time. Please try again later.');
            });
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('requestModal');
            if (event.target === modal) {
                hideRequestModal();
            }
        }