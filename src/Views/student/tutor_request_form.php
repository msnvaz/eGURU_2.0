<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: /student-login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Tutor - eGURU</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="/css/student/sidebar.css">
    <link rel="stylesheet" href="/css/student/nav.css">
    <link rel="stylesheet" href="/css/student/findtutor.css">
    <style>
        /* Additional custom styles for the request form */
        .tutor-profile {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .tutor-profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #E14177;
        }

        .tutor-info {
            flex: 1;
        }

        .tutor-info h2 {
            margin-top: 0;
            margin-bottom: 0.5rem;
            color: #2d3748;
            font-size: 1.5rem;
        }

        .tutor-level-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .tutor-info p {
            margin: 0.5rem 0;
            color: #4a5568;
        }

        .session-info {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .session-info h3 {
            margin-top: 0;
            color: #2d3748;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .session-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .session-form {
                grid-template-columns: 1fr;
            }
            
            .tutor-profile {
                flex-direction: column;
                text-align: center;
            }
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #4a5568;
        }

        .time-slots-section {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .time-slots-section h3 {
            margin-top: 0;
            color: #2d3748;
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .day-section {
            margin-bottom: 2rem;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 1.5rem;
        }

        .day-section:last-child {
            border-bottom: none;
        }

        .day-heading {
            font-size: 1.125rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1rem;
            padding-left: 0.5rem;
            border-left: 4px solid #E14177;
        }

        .time-slot-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .time-slot-item {
            background: #f7fafc;
            border-radius: 0.5rem;
            padding: 1rem;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .time-slot-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .time-slot-item.selected {
            background: #ebf8ff;
            border-color: #4299e1;
            box-shadow: 0 0 0 2px #4299e1;
        }

        .time-slot-item p {
            margin: 0;
            text-align: center;
            font-weight: 500;
        }

        .time-slot-date {
            font-size: 0.875rem;
            color: #718096;
            margin-top: 0.5rem !important;
        }

        .fee-calculation {
            background: #f0fff4;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid #c6f6d5;
        }

        .fee-calculation h4 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #2d3748;
        }

        .fee-details {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 0.75rem;
        }

        .fee-total {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px dashed #c6f6d5;
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            color: #2d3748;
        }

        .submit-button {
            width: 100%;
            padding: 1rem;
            background: #E14177;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 1.5rem;
        }

        .submit-button:hover {
            background: #e02362;
        }

        .no-slots-message {
            text-align: center;
            padding: 2rem;
            color: #718096;
        }

        .instruction-note {
            background: #ebf8ff;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #4299e1;
            color: #2c5282;
        }
        
        /* Make the instruction note stand out more for required time slot */
        .instruction-note.required {
            background: #fefcdd;
            border-left: 4px solid #eab308;
            color: #854d0e;
        }
        
        /* Style for success and error messages */
        .success-message,
        .error-message {
            padding: 1rem;
            border-radius: 0.5rem;
            margin: 1rem 0;
            display: none;
            text-align: center;
            font-weight: 500;
        }
        
        .success-message {
            background-color: #c6f6d5;
            color: #276749;
            border: 1px solid #9ae6b4;
        }
        
        .error-message {
            background-color: #fed7d7;
            color: #c53030;
            border: 1px solid #feb2b2;
        }
        
        .success-message.active,
        .error-message.active {
            display: block;
        }
        
        .selection-info {
            background: #ebf8ff;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1.5rem;
            display: none;
            border: 1px solid #bee3f8;
        }
        
        .selection-info.active {
            display: block;
        }
        
        .selection-info p {
            margin: 0.25rem 0;
            color: #2b6cb0;
        }
        
        .selection-info strong {
            color: #2c5282;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container">
            <a href="/student-findtutor" class="back-button">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Find Tutors</span>
            </a>

            <h1 class="page-title">Request Tutor</h1>
            
            <?php if (!empty($timeSlots)): ?>
                <div class="tutor-profile">
                    <div class="tutor-info">
                        <h2><?= htmlspecialchars($tutorInfo['tutor_first_name'] . ' ' . $tutorInfo['tutor_last_name']) ?></h2>
                        <span class="tutor-level-badge" style="background-color: #E14177; color: white;">
                            <?= htmlspecialchars($tutorLevel) ?>
                        </span>
                        <p><strong>Hourly Rate:</strong> $<?= number_format($hourlyRate, 2) ?></p>
                        <p><strong>Subjects:</strong> <?= htmlspecialchars(implode(', ', $subjects)) ?></p>
                    </div>
                </div>

                <form id="tutorRequestForm" method="POST" action="/student-process-tutor-request">
                    <input type="hidden" name="tutor_id" value="<?= htmlspecialchars($tutorInfo['tutor_id']) ?>">
                    
                    <div class="session-info">
                        <h3>Session Details</h3>
                        
                        <div class="instruction-note required">
                            <p><i class="fas fa-info-circle"></i> Please select a subject you want help with and choose an available time slot below. Both are required to send a request.</p>
                        </div>
                        
                        <div class="session-form">
                            <div class="form-group">
                                <label for="subject_id">Subject:</label>
                                <select name="subject_id" id="subject_id" class="form-control" required>
                                    <option value="">-- Select Subject --</option>
                                    <?php foreach ($subjects as $id => $subject): ?>
                                        <option value="<?= htmlspecialchars($id) ?>"><?= htmlspecialchars($subject) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="time-slots-section">
                        <h3>Available Time Slots <span class="required-indicator" style="color: #e53e3e;">*</span></h3>
                        
                        <div class="instruction-note">
                            <p><i class="fas fa-info-circle"></i> Click on a time slot to select it for your tutoring session.</p>
                        </div>
                        
                        <?php if (!empty($timeSlotsByDay)): ?>
                            <?php foreach ($timeSlotsByDay as $day => $slots): ?>
                                <div class="day-section">
                                    <h4 class="day-heading"><?= htmlspecialchars($day) ?></h4>
                                    <div class="time-slot-list">
                                        <?php foreach ($slots as $slot): ?>
                                            <?php 
                                                // Handle the case where getNextSessionDate might return a boolean or invalid value
                                                try {
                                                    $nextSession = $this->model->getNextSessionDate(
                                                        $slot['time_slot_id'] ?? 0, 
                                                        array_search($day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']) !== false 
                                                            ? array_search($day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']) 
                                                            : 0
                                                    );
                                                    
                                                    // Default date if the function returns false or invalid data
                                                    $sessionDate = is_array($nextSession) && isset($nextSession['next_session_date']) 
                                                        ? $nextSession['next_session_date'] 
                                                        : date('Y-m-d', strtotime('next ' . $day));
                                                        
                                                    $formattedDate = date('F j, Y', strtotime($sessionDate));
                                                } catch (Exception $e) {
                                                    // If any errors occur, use a default date (next occurrence of the day)
                                                    $sessionDate = date('Y-m-d', strtotime('next ' . $day));
                                                    $formattedDate = date('F j, Y', strtotime($sessionDate));
                                                }
                                            ?>
                                            <div class="time-slot-item" 
                                                 data-time-slot-id="<?= htmlspecialchars($slot['time_slot_id'] ?? '') ?>"
                                                 data-day="<?= htmlspecialchars($day) ?>"
                                                 data-date="<?= htmlspecialchars($sessionDate) ?>"
                                                 data-time="<?= htmlspecialchars(($slot['starting_time'] ?? '') . ' - ' . ($slot['ending_time'] ?? '')) ?>">
                                                <p><?= htmlspecialchars($slot['starting_time'] ?? '') ?> - <?= htmlspecialchars($slot['ending_time'] ?? '') ?></p>
                                                <p class="time-slot-date"><?= htmlspecialchars($formattedDate) ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <!-- Hidden fields to store selected time slot info -->
                            <input type="hidden" name="time_slot_id" id="time_slot_id">
                            <input type="hidden" name="day" id="selected_day">
                            <input type="hidden" name="scheduled_date" id="scheduled_date">
                            <input type="hidden" name="schedule_time" id="schedule_time">
                            
                            <!-- Selection info display -->
                            <div class="selection-info" id="selection-info">
                                <p><strong>Selected Time:</strong> <span id="selected-time-display">None selected</span></p>
                                <p><strong>Selected Date:</strong> <span id="selected-date-display">None selected</span></p>
                            </div>

                            <div class="fee-calculation">
                                <h4>Session Fee Calculation</h4>
                                <div class="fee-details">
                                    <div>Hourly Rate:</div>
                                    <div>$<?= number_format($hourlyRate, 2) ?></div>
                                    <div>Session Duration:</div>
                                    <div>2 hours</div>
                                </div>
                                <div class="fee-total">
                                    <div>Estimated Total:</div>
                                    <div>$<?= number_format($hourlyRate * 2, 2) ?></div>
                                </div>
                            </div>

                        <?php else: ?>
                            <div class="no-slots-message">
                                <p>There are no matching time slots available with this tutor. Please check back later or select another tutor.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" id="submitRequest" class="submit-button">
                        <i class="fas fa-paper-plane"></i> Send Tutor Request
                    </button>
                </form>

            <?php else: ?>
                <div class="no-slots-message">
                    <p>Tutor information not found or no matching time slots available with this tutor. Please go back and select another tutor.</p>
                    <a href="/student-findtutor" class="submit-button" style="display: inline-block; width: auto; margin-top: 1rem;">
                        <i class="fas fa-search"></i> Find Another Tutor
                    </a>
                </div>
            <?php endif; ?>

            <!-- Success Message -->
            <div id="successMessage" class="success-message">
                Request sent successfully!
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="error-message">
                <!-- Error message will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Direct selection for time slots without tab navigation
            const timeSlots = document.querySelectorAll('.time-slot-item');
            const selectionInfo = document.getElementById('selection-info');
            const selectedTimeDisplay = document.getElementById('selected-time-display');
            const selectedDateDisplay = document.getElementById('selected-date-display');
            
            // Make sure form elements exist before trying to access them
            const timeSlotIdInput = document.getElementById('time_slot_id');
            const selectedDayInput = document.getElementById('selected_day');
            const scheduledDateInput = document.getElementById('scheduled_date');
            const scheduleTimeInput = document.getElementById('schedule_time');
            
            if (timeSlots.length > 0) {
                timeSlots.forEach(slot => {
                    slot.addEventListener('click', function() {
                        // First, remove selected class from all time slots
                        timeSlots.forEach(s => s.classList.remove('selected'));
                        
                        // Then apply selected class to the clicked time slot
                        this.classList.add('selected');
                        
                        // Get data attributes
                        const timeSlotId = this.getAttribute('data-time-slot-id');
                        const day = this.getAttribute('data-day');
                        const date = this.getAttribute('data-date');
                        const time = this.getAttribute('data-time');
                        
                        // Update hidden inputs
                        if (timeSlotIdInput) timeSlotIdInput.value = timeSlotId || '';
                        if (selectedDayInput) selectedDayInput.value = day || '';
                        if (scheduledDateInput) scheduledDateInput.value = date || '';
                        if (scheduleTimeInput) scheduleTimeInput.value = time || '';
                        
                        // Update display
                        if (selectedTimeDisplay) selectedTimeDisplay.textContent = time || 'None selected';
                        if (selectedDateDisplay) selectedDateDisplay.textContent = day + ', ' + (date ? new Date(date).toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric'}) : '');
                        
                        // Show selection info
                        if (selectionInfo) selectionInfo.classList.add('active');
                        
                        // Log to console for debugging
                        console.log('Selected time slot:', {
                            id: timeSlotId,
                            day: day,
                            date: date,
                            time: time
                        });
                    });
                    
                    // Add keyboard support
                    slot.setAttribute('tabindex', '0');
                    slot.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.click();
                        }
                    });
                });
            }
            
            // Form submission handling
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    console.log("Form submission started");
                    
                    // Basic validation
                    const subjectId = document.getElementById('subject_id').value;
                    if (!subjectId) {
                        showError('Please select a subject.');
                        return;
                    }
                    
                    // Direct DOM validation for time slot selection
                    const selectedSlot = document.querySelector('.time-slot-item.selected');
                    if (!selectedSlot) {
                        showError('Please select a time slot to continue.');
                        return;
                    }
                    
                    // Verify all needed data attributes are present
                    const timeSlotId = selectedSlot.getAttribute('data-time-slot-id');
                    const day = selectedSlot.getAttribute('data-day');
                    const date = selectedSlot.getAttribute('data-date');
                    const time = selectedSlot.getAttribute('data-time');
                    
                    console.log("Selected time slot data:", {
                        id: timeSlotId,
                        day: day,
                        date: date,
                        time: time
                    });
                    
                    if (!timeSlotId || !day || !date || !time) {
                        showError('Missing required time slot information. Please try selecting again.');
                        return;
                    }
                    
                    // Set the form field values directly from the selected slot
                    document.getElementById('time_slot_id').value = timeSlotId;
                    document.getElementById('selected_day').value = day;
                    document.getElementById('scheduled_date').value = date;
                    
                    // Format the time - extract just the starting time for the database
                    const startTime = time.split(' - ')[0].trim();
                    document.getElementById('schedule_time').value = startTime;
                    
                    console.log("Formatted start time:", startTime);
                    
                    // All validation passed, submit form
                    const formData = new FormData(form);
                    
                    // Console log for debugging
                    console.log('Form submission data:');
                    for (const pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }
                    
                    fetch('/student-process-tutor-request', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            showSuccess(data.message || 'Request sent successfully!');
                            setTimeout(() => {
                                window.location.href = '/student-session'; // Change this line from '/student-dashboard' to '/student-session'
                            }, 2000);
                        } else {
                            showError(data.message || 'An error occurred. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('An error occurred while processing your request. Please try again.');
                    });
                });
            }
            
            // Helper functions
            function showSuccess(message) {
                const successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    successMessage.textContent = message;
                    successMessage.classList.add('active');
                    setTimeout(() => {
                        successMessage.classList.remove('active');
                    }, 5000);
                }
            }
            
            function showError(message) {
                const errorMessage = document.getElementById('errorMessage');
                if (errorMessage) {
                    errorMessage.textContent = message;
                    errorMessage.classList.add('active');
                    
                    // Scroll to error message
                    errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    setTimeout(() => {
                        errorMessage.classList.remove('active');
                    }, 5000);
                }
            }
        });
    </script>
</body>
</html>