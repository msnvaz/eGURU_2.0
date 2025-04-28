<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


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
    <link rel="stylesheet" href="/css/student/requestform.css" >
    <link rel="stylesheet" href="/css/student/header.css" class="css">
</head>
<body>

<?php require '../src/Views/student/sidebar.php'; ?>
    <div class="main-content">
    <?php include 'header.php'; ?>

        <div class="container">
            <a href="/student-findtutor" class="back-button" style="margin-top: 25px; border-radius:14px;">
                <i class="fas fa-arrow-left"></i>
                <span>Back to Find Tutors</span>
            </a>

            <h1 class="page-title">Request Tutor</h1>
            <?php
            
            ?>
            <?php if (!empty($timeSlots)): ?>
                <div class="tutor-profile">
                    <div class="tutor-info">
                        <h2><?= htmlspecialchars($tutorInfo['tutor_first_name'] . ' ' . $tutorInfo['tutor_last_name']) ?></h2>
                        <span class="tutor-level-badge" style="background-color: #E14177; color: white;">
                            <?= htmlspecialchars($tutorLevel) ?>
                        </span>
                        <p><strong>Hourly Rate:</strong> Rs.<?= number_format($hourlyRate, 2) ?></p>
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
                                                
                                                try {
                                                    $nextSession = $this->model->getNextSessionDate(
                                                        $slot['time_slot_id'] ?? 0, 
                                                        array_search($day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']) !== false 
                                                            ? array_search($day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']) 
                                                            : 0
                                                    );
                                                    
                                                    
                                                    $sessionDate = is_array($nextSession) && isset($nextSession['next_session_date']) 
                                                        ? $nextSession['next_session_date'] 
                                                        : date('Y-m-d', strtotime('next ' . $day));
                                                        
                                                    $formattedDate = date('F j, Y', strtotime($sessionDate));
                                                } catch (Exception $e) {
                                                    
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

                            
                            <input type="hidden" name="time_slot_id" id="time_slot_id">
                            <input type="hidden" name="day" id="selected_day">
                            <input type="hidden" name="scheduled_date" id="scheduled_date">
                            <input type="hidden" name="schedule_time" id="schedule_time">
                            
                           
                            <div class="selection-info" id="selection-info">
                                <p><strong>Selected Time:</strong> <span id="selected-time-display">None selected</span></p>
                                <p><strong>Selected Date:</strong> <span id="selected-date-display">None selected</span></p>
                            </div>

                            <div class="fee-calculation">
                                <h4>Session Fee Calculation</h4>
                                <div class="fee-details">
                                    <div>Hourly Rate:</div>
                                    <div>Rs.<?= number_format($hourlyRate, 2) ?></div>
                                    <div>Session Duration:</div>
                                    <div>2 hours</div>
                                </div>
                                <div class="fee-total">
                                    <div>Estimated Total:</div>
                                    <div>Rs.<?= number_format($hourlyRate * 2, 2) ?></div>
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

            
            <div id="successMessage" class="success-message">
                Request sent successfully!
            </div>

            
            <div id="errorMessage" class="error-message">
                

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            const timeSlots = document.querySelectorAll('.time-slot-item');
            const selectionInfo = document.getElementById('selection-info');
            const selectedTimeDisplay = document.getElementById('selected-time-display');
            const selectedDateDisplay = document.getElementById('selected-date-display');
            const form = document.getElementById('tutorRequestForm');
            
            
            const timeSlotIdInput = document.getElementById('time_slot_id');
            const selectedDayInput = document.getElementById('selected_day');
            const scheduledDateInput = document.getElementById('scheduled_date');
            const scheduleTimeInput = document.getElementById('schedule_time');
            
            if (timeSlots.length > 0) {
                timeSlots.forEach(slot => {
                    slot.addEventListener('click', function() {
                        
                        timeSlots.forEach(s => s.classList.remove('selected'));
                        
                        
                        this.classList.add('selected');
                        
                        
                        const timeSlotId = this.getAttribute('data-time-slot-id');
                        const day = this.getAttribute('data-day');
                        const date = this.getAttribute('data-date');
                        const time = this.getAttribute('data-time');
                        
                        
                        if (timeSlotIdInput) timeSlotIdInput.value = timeSlotId || '';
                        if (selectedDayInput) selectedDayInput.value = day || '';
                        if (scheduledDateInput) scheduledDateInput.value = date || '';
                        if (scheduleTimeInput) scheduleTimeInput.value = time || '';
                        
                        
                        if (selectedTimeDisplay) selectedTimeDisplay.textContent = time || 'None selected';
                        if (selectedDateDisplay) selectedDateDisplay.textContent = day + ', ' + (date ? new Date(date).toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric'}) : '');
                        
                        
                        if (selectionInfo) selectionInfo.classList.add('active');
                        
                        
                        console.log('Selected time slot:', {
                            id: timeSlotId,
                            day: day,
                            date: date,
                            time: time
                        });
                    });
                    
                    
                    slot.setAttribute('tabindex', '0');
                    slot.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.click();
                        }
                    });
                });
            }
            
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    console.log("Form submission started");
                    
                    
                    const subjectId = document.getElementById('subject_id').value;
                    if (!subjectId) {
                        showError('Please select a subject.');
                        return;
                    }
                    
                    
                    const selectedSlot = document.querySelector('.time-slot-item.selected');
                    if (!selectedSlot) {
                        showError('Please select a time slot to continue.');
                        return;
                    }
                    
                    
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
                    
                    
                    document.getElementById('time_slot_id').value = timeSlotId;
                    document.getElementById('selected_day').value = day;
                    document.getElementById('scheduled_date').value = date;
                    
                    
                    const startTime = time.split(' - ')[0].trim();
                    document.getElementById('schedule_time').value = startTime;
                    
                    console.log("Formatted start time:", startTime);
                    
                    
                    const formData = new FormData(form);
                    
                    
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
                                window.location.href = '/student-session'; 
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