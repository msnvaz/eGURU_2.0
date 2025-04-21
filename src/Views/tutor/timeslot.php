<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Time Slots - eGURU</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/tutor/sidebar.css">
    <link rel="stylesheet" href="css/tutor/timeslot.css">
    
</head>
<body>

<?php $page = "timeslot"; ?>
<?php include 'sidebar.php'; ?>
<?php include '../src/Views/tutor/header.php'; ?>

<div class="container">
    <h2>Select Your Available Time Slots by Day</h2>

    <!-- Edit button -->
    <button type="button" id="editBtn">
        <i class="fas fa-edit"></i> Edit Time Slots
    </button>

    <form method="post" action="/tutor-timeslot-save" id="timeslotForm">
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

<!-- Success Modal -->
<div id="successModal" class="modal success-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <!--<div class="modal-icon">
            <i class="fas fa-check-circle"></i>
        </div>-->
        <h3 class="modal-title">Success!</h3>
        <p class="modal-message">Your time slots have been saved successfully.</p>
        <div class="modal-buttons">
            <button class="modal-btn btn-success close-modal-btn">OK</button>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="errorModal" class="modal error-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <!--<div class="modal-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>-->
        <h3 class="modal-title">Error</h3>
        <p class="modal-message" id="errorMessage">There was an error saving your time slots.</p>
        <div class="modal-buttons">
            <button class="modal-btn btn-primary close-modal-btn">OK</button>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal confirm-modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <!--<div class="modal-icon">
            <i class="fas fa-question-circle"></i>
        </div>-->
        <h3 class="modal-title">Confirm Changes</h3>
        <p class="modal-message">Are you sure you want to save these time slots? This will update your availability for students to book sessions.</p>
        <div class="modal-buttons">
            <button class="modal-btn btn-secondary close-modal-btn" id="cancelSave">Cancel</button>
            <button class="modal-btn btn-primary" id="confirmSave">Confirm</button>
        </div>
    </div>
</div>

<script>
    // Check if there's a success message in URL parameters
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success')) {
            showModal('successModal');
            // Remove the parameter from URL without reloading the page
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        } else if (urlParams.has('error')) {
            const errorMsg = urlParams.get('error') || 'There was an error saving your time slots.';
            document.getElementById('errorMessage').textContent = errorMsg;
            showModal('errorModal');
            // Remove the parameter from URL without reloading the page
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        }
    });

    document.getElementById('editBtn').addEventListener('click', function() {
        // Enable all checkboxes
        const checkboxes = document.querySelectorAll('#timeslotForm input[type="checkbox"]');
        checkboxes.forEach(cb => cb.disabled = false);

        // Show the Save button
        document.getElementById('saveBtn').style.display = 'inline-block';

        // Hide the Edit button
        this.style.display = 'none';
    });

    // Show confirmation modal before submitting form
    document.getElementById('timeslotForm').addEventListener('submit', function(e) {
        e.preventDefault();
        showModal('confirmModal');
    });

    // When user confirms in the modal, submit the form
    document.getElementById('confirmSave').addEventListener('click', function() {
        document.getElementById('timeslotForm').submit();
        hideModal('confirmModal');
    });

    // Modal functions
    function showModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function hideModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Event listeners for modal close buttons
    const closeButtons = document.querySelectorAll('.close-modal, .close-modal-btn');
    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            modal.style.display = 'none';
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>

</body>
</html>