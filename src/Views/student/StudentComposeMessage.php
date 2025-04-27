
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Student - Compose Message</title>
    <link rel="icon" type="image/png" href="/images/eGURU_3.png">
    <link rel="stylesheet" href="/css/student/sidebar.css">
    <link rel="stylesheet" href="/css/student/nav.css">
    <link rel="stylesheet" href="/css/student/header.css">
    <link rel="stylesheet" href="/css/student/StudentInbox.css">
    <link rel="stylesheet" href="/css/student/StudentComposeMessage.css">
    <link rel="stylesheet" href="/css/student/StudentOutbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>


<body>
<?php $page="inbox"; ?>

<?php include '../src/Views/student/header.php'; ?>
<?php include 'sidebar.php'; ?>
    
    <div class="main">
        <br><br>
        <div class="student-dashboard">
            <div class="inbox-tabs">
                <a href="/student-inbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'inbox') ? 'active' : '' ?>">Inbox<span class="notification-badge"><?= htmlspecialchars($unreadCount) ?></span></a>
                <a href="/student-inbox?status=archived" class="tab-link <?= (isset($activeTab) && $activeTab === 'archived') ? 'active' : '' ?>">Archived</a>
                <a href="/student-compose-message" class="tab-link <?= (isset($activeTab) && $activeTab === 'compose') ? 'active' : '' ?>">Compose</a>
                <a href="/student-outbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'outbox') ? 'active' : '' ?>">Outbox</a>
            </div>
            
            <div class="compose-container">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">
                        <?= htmlspecialchars($_GET['success']) ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-error">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>
                
                <form action="/student-send-message" method="post" class="compose-form">
                    <label for="recipient_type">Recipient Type:</label>
                    <select id="recipient_type" name="recipient_type" required>
                        <option value="admin">Admin</option>
                        <option value="tutor">Tutor</option>
                    </select>
                    
                    <input type="hidden" id="message_type" name="message_type" value="admin"> <!-- Add this hidden input -->

                    <div id="tutor-select" style="display: none;">
                        <label for="tutor_id">Select Tutor:</label>
                        <select id="tutor_id" name="tutors[]" multiple required>
                            <?php foreach ($tutors as $tutor): ?>
                                <option value="<?= $tutor['tutor_id'] ?>">
                                    <?= htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']) ?> (#<?= $tutor['tutor_id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                    
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                    
                    <div class="form-buttons">
                        <button type="reset">Reset</button>
                        <button type="submit">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Update your existing script at the bottom of StudentComposeMessage.php
document.addEventListener('DOMContentLoaded', function() {
    // Set initial state based on default selected value
    const recipientType = document.getElementById('recipient_type');
    const tutorSelect = document.getElementById('tutor-select');
    const tutorField = document.getElementById('tutor_id');
    
    // Set initial state
    if (recipientType.value === 'admin') {
        tutorSelect.style.display = 'none';
        tutorField.required = false;
    }
    
    // Add your existing event listener
    recipientType.addEventListener('change', function() {
        if (this.value === 'tutor') {
            tutorSelect.style.display = 'block';
            tutorField.required = true;
            document.getElementById('message_type').value = 'tutor';
        } else {
            tutorSelect.style.display = 'none';
            tutorField.required = false;
            document.getElementById('message_type').value = 'admin';
        }
    });
});
    </script>
</body>
</html>