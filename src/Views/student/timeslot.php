<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = "timeslot";
include __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Time Slots - eGURU</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/timeslot.css">
</head>
<body>
    
    <?php include 'sidebar.php'; ?>

    <div class="container">
    <h2>Select Your Available Time Slots by Day</h2>

    
    <button type="button" id="editBtn">
        <i class="fas fa-edit"></i> Edit Time Slots
    </button>

    <form method="post" action="/student-timeslot-save" id="timeslotForm">
        <?php 
            $daysOfWeek = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
            foreach ($daysOfWeek as $day): 
                $selectedForDay = $selectedSlots[$day] ?? [];
        ?>
            <div class="day-section">
                <h3><i class="far fa-calendar-alt"></i> <?= $day ?></h3>
                <?php foreach ($allTimeSlots as $slot): ?>
                    <div class="slot">
                        <label>
                            <input 
                                type="checkbox" 
                                name="<?= $day ?>[]" 
                                value="<?= $slot['time_slot_id'] ?>"
                                <?= in_array($slot['time_slot_id'], $selectedForDay) ? 'checked' : '' ?>
                                disabled
                            >
                            <?= htmlspecialchars($slot['starting_time']) ?> - <?= htmlspecialchars($slot['ending_time']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit" id="saveBtn">
            <i class="fas fa-save"></i> Save Availability
        </button>
    </form>
</div>


<div id="successModal" class="modal success-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        
        <h3 class="modal-title">Success!</h3>
        <p class="modal-message">Your time slots have been saved successfully.</p>
        <div class="modal-buttons">
            <button class="modal-btn btn-success close-modal-btn">OK</button>
        </div>
    </div>
</div>


<div id="errorModal" class="modal error-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        
        <h3 class="modal-title">Error</h3>
        <p class="modal-message" id="errorMessage">There was an error saving your time slots.</p>
        <div class="modal-buttons">
            <button class="modal-btn btn-primary close-modal-btn">OK</button>
        </div>
    </div>
</div>


<div id="confirmModal" class="modal confirm-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        
        <h3 class="modal-title">Confirm Changes</h3>
        <p class="modal-message">Are you sure you want to save these time slots? This will update your availability for tutors to schedule sessions.</p>
        <div class="modal-buttons">
            <button class="modal-btn btn-secondary close-modal-btn" id="cancelSave">Cancel</button>
            <button class="modal-btn btn-primary" id="confirmSave">Confirm</button>
        </div>
    </div>
</div>

<script src="js/student/timeslot.js"></script>

</body>
</html>