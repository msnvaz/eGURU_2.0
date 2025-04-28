<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Requests</title>
    <script src="request.js"></script>
    <link rel="stylesheet" href="/css/tutor/request.css">
    <link rel="stylesheet" href="/css/tutor/dashboard.css">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .modal-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
            
        }

    </style>
</head>
<body>

<?php $page="request"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>

            
    <div id="body">
    <?php
       // include 'sidebar.php';
    ?>
    
    <div class="request_container">
    <div class="request-header">
        <div id="active-tab" class="tab active" onclick="toggleRequests('active')">Active Student Requests</div>
        <div id="rejected-tab" class="tab" onclick="toggleRequests('rejected')">Rejected Student Requests</div>
        <div id="cancelled-tab" class="tab" onclick="toggleRequests('cancelled')">Cancelled Student Sessions</div>
    </div>
    
    <div id="active-requests" class="requests">
        <div class="request">
            <div><b>Session ID</b></div>
            <div><b>Subject</b></div>
            <div><b>Scheduled Date</b></div>
            <div><b>Scheduled Time</b></div>
            <div><b>Student Name</b></div>
            <div><b>Request Action</b></div>
        </div>

        <?php if (!empty($active_requests)) : ?>
            <?php foreach ($active_requests as $request) : ?>
                <div class="request">
                    <div><?= htmlspecialchars($request['session_id']) ?></div>
                    <div><?= htmlspecialchars($request['subject_name']) ?></div>
                    <div><?= htmlspecialchars($request['scheduled_date'] ?? 'Not Scheduled') ?></div>
                    <div><?= htmlspecialchars($request['schedule_time'] ?? 'Not Scheduled') ?></div>
                    
                    <!-- Make student name clickable -->
                    <div>
                        <a href="/tutor-student-profile/<?= $request['student_id'] ?>">
                            <?= htmlspecialchars($request['student_first_name'] . ' ' . $request['student_last_name']) ?>
                        </a>
                    </div>


                    <div class="buttons">
                        <form method="POST" action="/handle-session-request">
                            <input type="hidden" name="session_id" value="<?= $request['session_id'] ?>">
                            <input type="hidden" name="action" value="">
                            <button type="button" data-action="accept" class="accept">Accept</button>
                            <button type="button" data-action="decline" class="decline">Decline</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="request"><div colspan="5">No new requests found.</div></div>
        <?php endif; ?>
    </div>

    <div id="rejected-requests" class="requests" style="display: none;">
        <div class="request">
            <div><b>Session ID</b></div>
            <div><b>Subject</b></div>
            <div><b>Scheduled date</b></div>
            <div><b>Scheduled time</b></div>
            <div><b>Student Name</b></div>
        </div>

        <?php foreach ($rejected_requests as $request): ?>
            <div class="request">
                <div><?= htmlspecialchars($request['session_id']) ?></div>
                <div><?= htmlspecialchars($request['subject_name']) ?></div>
                <div><?= htmlspecialchars($request['scheduled_date'] ?? 'Not Scheduled') ?></div>
                <div><?= htmlspecialchars($request['schedule_time'] ?? 'Not Scheduled') ?></div>
                <div>
                    <a href="/tutor-student-profile/<?= $request['student_id'] ?>">
                        <?= htmlspecialchars($request['student_first_name'] . ' ' . $request['student_last_name']) ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="cancelled-requests" class="requests" style="display: none;">
        <div class="request">
            <div><b>Session ID</b></div>
            <div><b>Subject</b></div>
            <div><b>Scheduled date</b></div>
            <div><b>Scheduled time</b></div>
            <div><b>Student Name</b></div>
        </div>

        <?php foreach ($cancelled_requests as $request): ?>
            <div class="request">
                <div><?= htmlspecialchars($request['session_id']) ?></div>
                <div><?= htmlspecialchars($request['subject_name']) ?></div>
                <div><?= htmlspecialchars($request['scheduled_date'] ?? 'Not Scheduled') ?></div>
                <div><?= htmlspecialchars($request['schedule_time'] ?? 'Not Scheduled') ?></div>
                <div>
                    <a href="/tutor-student-profile/<?= $request['student_id'] ?>">
                        <?= htmlspecialchars($request['student_first_name'] . ' ' . $request['student_last_name']) ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
    function toggleRequests(tab) {
        const activeTab = document.getElementById('active-tab');
        const rejectedTab = document.getElementById('rejected-tab');
        const cancelledTab = document.getElementById('cancelled-tab');

        const activeRequests = document.getElementById('active-requests');
        const rejectedRequests = document.getElementById('rejected-requests');
        const cancelledRequests = document.getElementById('cancelled-requests');

        if (tab === 'active') {
            activeRequests.style.display = 'block';
            rejectedRequests.style.display = 'none';
            cancelledRequests.style.display = 'none';

            activeTab.classList.add('active');
            rejectedTab.classList.remove('active');
            cancelledTab.classList.remove('active');

        } else if (tab === 'rejected') {
            activeRequests.style.display = 'none';
            rejectedRequests.style.display = 'block';
            cancelledRequests.style.display = 'none';

            activeTab.classList.remove('active');
            rejectedTab.classList.add('active');
            cancelledTab.classList.remove('active');

        } else if (tab === 'cancelled') {
            activeRequests.style.display = 'none';
            rejectedRequests.style.display = 'none';
            cancelledRequests.style.display = 'block';

            activeTab.classList.remove('active');
            rejectedTab.classList.remove('active');
            cancelledTab.classList.add('active');
        }
    }
</script>

    </div>

    <!-- Confirmation Modal -->
<div id="confirmationModal" class="modal-overlay" style="display: none;">
    <div class="modal-box">
        <p id="confirmationText">Are you sure?</p>
        <div class="modal-actions">
            <button class="accept" id="confirmYes">Proceed</button>
            <button class="decline" id="confirmNo">Cancel</button>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('confirmationModal');
    const modalText = document.getElementById('confirmationText');
    const confirmYes = document.getElementById('confirmYes');
    const confirmNo = document.getElementById('confirmNo');

    let selectedForm = null;
    let selectedAction = '';

    document.querySelectorAll('form[action="/handle-session-request"]').forEach(form => {
        form.querySelectorAll('button[data-action]').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                selectedForm = form;
                selectedAction = this.getAttribute('data-action');
                modalText.textContent = `Are you sure you want to ${selectedAction} this session request?`;
                modal.style.display = 'flex';
            });
        });
    });

    confirmYes.addEventListener('click', () => {
        if (selectedForm) {
            // Set the hidden action input
            selectedForm.querySelector('input[name="action"]').value = selectedAction;
            modal.style.display = 'none';
            selectedForm.submit();
        }
    });

    confirmNo.addEventListener('click', () => {
        modal.style.display = 'none';
        selectedForm = null;
    });
</script>



</body>
</html>
