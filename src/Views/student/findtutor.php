<!-- findtutor.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Finder</title>
    <link rel="stylesheet" href="css/student/new.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
    
    <style>
        

        .filters {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            flex: 1;
        }

        button {
            padding: 8px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .results-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
            
        }

        .tutor-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: box-shadow 0.3s;
            width: 300px;
        }

        .tutor-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .tutor-card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 14px;
            margin-top: 8px;
        }

        .status-available {
            background-color: #e7f7ed;
            color: #0a7c2e;
        }

        .status-unavailable {
            background-color: #ffe9e9;
            color: #cf0000;
        }

        .loading {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
        }

        .error {
            color: #dc3545;
            padding: 10px;
            background-color: #ffe9e9;
            border-radius: 4px;
            margin: 10px 0;
        }

        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .popup-content {
            position: relative;
            background-color: white;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
        }
        .request-btn {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }

        .request-btn:hover {
            background-color: #218838;
        }

        .request-btn:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }

        /* Request form popup styles */
        .request-popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .request-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: 50px auto;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            display: none;
        }
    </style>
</head>
<body>
<?php include '../src/Views/student/header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <div class="findtutor-bodyform">
        <div class="filters">
            <select id="grade">
                <option value="">Select Grade</option>
                <option value="6">Grade 6</option>
                <option value="7">Grade 7</option>
                <option value="8">Grade 8</option>
                <option value="9">Grade 9</option>
                <option value="10">Grade 10</option>
                <option value="11">Grade 11</option>
            </select>

            <select id="subject">
                <option value="">Select Subject</option>
                <option value="Science">Science</option>
                <option value="Math">Math</option>
                <option value="History">History</option>
                <option value="ICT">ICT</option>
                <option value="Geography">Geography</option>
                <option value="English">English</option>
            </select>

            <select id="experience">
                <option value="">Select Experience Level</option>
                <option value="Undergraduate">Undergraduate</option>
                <option value="Graduate">Graduate</option>
                <option value="Retired">Retired</option>
                <option value="Full-time">Full-time</option>
            </select>

            <button id="searchBtn">Search Tutors</button>
        </div>

        <div id="error" class="error" style="display: none;"></div>
        <div id="loading" class="loading" style="display: none;">Searching for tutors...</div>
        <div id="results" class="results-container"></div>
    </div>

    <!-- Tutor Details Popup -->
    <div id="tutorPopup" class="popup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h2 id="tutorName"></h2>
            <p id="tutorQualification"></p>
            <p id="tutorExperience"></p>
            <p id="tutorRating"></p>
            <p id="tutorFees"></p>
        </div>
    </div>

    <!-- Add Request Form Popup -->
    <div id="requestPopup" class="request-popup">
        <div class="request-form">
            <h3>Request Tutor</h3>
            <div id="requestSuccess" class="success-message"></div>
            <form id="tutorRequestForm">
                <input type="hidden" id="requestTutorId" name="tutor_id">
                <div class="form-group">
                    <label for="preferred_time">Preferred Time</label>
                    <input type="datetime-local" id="preferred_time" name="preferred_time" required>
                </div>
                <div class="form-group">
                    <label for="message">Message to Tutor</label>
                    <textarea id="message" name="message" rows="4" required placeholder="Explain what you'd like help with..."></textarea>
                </div>
                <div class="form-buttons">
                    <button type="button" onclick="closeRequestPopup()" class="btn">Cancel</button>
                    <button type="submit" class="request-btn">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('searchBtn').addEventListener('click', searchTutors);

        function searchTutors() {
            const grade = document.getElementById('grade').value;
            const subject = document.getElementById('subject').value;
            const experience = document.getElementById('experience').value;

            // Show loading state
            document.getElementById('loading').style.display = 'block';
            document.getElementById('error').style.display = 'none';
            document.getElementById('results').innerHTML = '';

            const formData = new FormData();
            formData.append('grade', grade);
            formData.append('subject', subject);
            formData.append('experience', experience);

            fetch('/student-search-tutor', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Search failed');
                }
                return response.json();
            })
            .then(tutors => {
                displayResults(tutors);
            })
            .catch(error => {
                document.getElementById('error').textContent = 'Failed to search tutors. Please try again.';
                document.getElementById('error').style.display = 'block';
                console.error('Error:', error);
            })
            .finally(() => {
                document.getElementById('loading').style.display = 'none';
            });
        }

        function displayResults(tutors) {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '';

            if (tutors.length === 0) {
                resultsDiv.innerHTML = '<p>No tutors found matching your criteria.</p>';
                return;
            }

            tutors.forEach(tutor => {
                const card = document.createElement('div');
                card.className = 'tutor-card';
                card.onclick = () => showTutorDetails(tutor.tutor_id);

                const statusClass = tutor.availability === 'available' ? 'status-available' : 'status-unavailable';
                
                card.innerHTML = `
                    <h3>${tutor.name}</h3>
                    <p>Subject: ${tutor.subject}</p>
                    <p>Grade: ${tutor.grade}</p>
                    <p>Experience: ${tutor.tutor_level}</p>
                    <p>Rating: ${tutor.rating} / 5.0</p>
                    <p>Hourly Rate: $${tutor.hour_fees}</p>
                    <span class="status-badge ${statusClass}">
                        ${tutor.availability}
                    </span>
                `;

                resultsDiv.appendChild(card);
            });
        }

        function showTutorDetails(tutorId) {
            fetch(`/student-tutor-details/${tutorId}`)
                .then(response => response.json())
                .then(tutor => {
                    document.getElementById('tutorName').textContent = tutor.name;
                    document.getElementById('tutorQualification').textContent = `Qualification: ${tutor.qualification}`;
                    document.getElementById('tutorExperience').textContent = `Experience: ${tutor.tutor_level}`;
                    document.getElementById('tutorRating').textContent = `Rating: ${tutor.rating} / 5.0`;
                    document.getElementById('tutorFees').textContent = `Hourly Rate: $${tutor.hour_fees}`;
                    document.getElementById('tutorPopup').style.display = 'block';
                })
                .catch(error => console.error('Error:', error));
        }

        function closePopup() {
            document.getElementById('tutorPopup').style.display = 'none';
        }
        function displayResults(tutors) {
            const resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = '';

            if (tutors.length === 0) {
                resultsDiv.innerHTML = '<p>No tutors found matching your criteria.</p>';
                return;
            }

            tutors.forEach(tutor => {
                const card = document.createElement('div');
                card.className = 'tutor-card';

                const isAvailable = tutor.availability === 'available';
                const statusClass = isAvailable ? 'status-available' : 'status-unavailable';
                
                card.innerHTML = `
                    <h3>${tutor.name}</h3>
                    <p>Subject: ${tutor.subject}</p>
                    <p>Grade: ${tutor.grade}</p>
                    <p>Experience: ${tutor.tutor_level}</p>
                    <p>Rating: ${tutor.rating} / 5.0</p>
                    <p>Hourly Rate: $${tutor.hour_fees}</p>
                    <span class="status-badge ${statusClass}">
                        ${tutor.availability}
                    </span>
                    ${isAvailable ? 
                        `<button class="request-btn" onclick="showRequestForm(${tutor.tutor_id}, '${tutor.name}')">
                            Request Tutor
                        </button>` : 
                        ''
                    }
                `;

                // Add click handler for card details
                card.querySelector('h3').onclick = () => showTutorDetails(tutor.tutor_id);
                resultsDiv.appendChild(card);
            });
        }

        // Add new functions for request handling
        function showRequestForm(tutorId, tutorName) {
            document.getElementById('requestTutorId').value = tutorId;
            document.getElementById('requestSuccess').style.display = 'none';
            document.getElementById('requestPopup').style.display = 'block';
        }

        function closeRequestPopup() {
            document.getElementById('requestPopup').style.display = 'none';
            document.getElementById('tutorRequestForm').reset();
        }

        // Initialize request form handler
        document.getElementById('tutorRequestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('/student-request-tutor', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('requestSuccess').textContent = 'Request sent successfully!';
                    document.getElementById('requestSuccess').style.display = 'block';
                    setTimeout(closeRequestPopup, 2000);
                } else {
                    throw new Error(data.message || 'Failed to send request');
                }
            })
            .catch(error => {
                alert('Error sending request: ' + error.message);
            });
        });

        // Close request popup when clicking outside
        window.onclick = function(event) {
            const popup = document.getElementById('requestPopup');
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        }
        
    </script>
</body>
</html>