<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Tutor - Compose Message</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link rel="stylesheet" href="/css/tutor/inbox.css">
    <link rel="stylesheet" href="/css/tutor/outbox.css">
    <link rel="stylesheet" href="/css/tutor/compose_message.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <style>
        .notification-badge {
            display: inline-block;
            background-color: #ff5869;
            color: white;
            border-radius: 50%;
            padding: 4px 7px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            text-align: center;
            min-width: 20px;
            height: 20px;
        }

    </style>
</head>
<body>
    
<?php $page="inbox"; ?>


<?php include 'sidebar.php'; ?>


<?php include '../src/Views/tutor/header.php'; ?>

    
    <div class="main">
        <br>
        <div class="tutor-dashboard">
            <div class="inbox-tabs">
                <a href="/tutor-inbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'inbox') ? 'active' : '' ?>">Inbox <span class="notification-badge"><?= htmlspecialchars($unreadCount)?></span>
                </a>
                <a href="/tutor-inbox?status=archived" class="tab-link <?= (isset($activeTab) && $activeTab === 'archived') ? 'active' : '' ?>">Archived</a>
                <a href="/tutor-compose-message" class="tab-link <?= (isset($activeTab) && $activeTab === 'compose') ? 'active' : '' ?>">Compose</a>
                <a href="/tutor-outbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'outbox') ? 'active' : '' ?>">Outbox</a>
            </div>

            <?php
                $messageType = $_GET['type'] ?? 'student'; 
            ?>

                    
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
                
                <div class="message-type-tabs">
                    <button class="message-type-tab <?= $messageType === 'student' ? 'active' : '' ?>" onclick="window.location.href='/tutor-compose-message?type=student'">
                        <i class="fas fa-user-graduate"></i> Send to Students
                    </button>
                    <button class="message-type-tab <?= $messageType === 'admin' ? 'active' : '' ?>" onclick="window.location.href='/tutor-compose-message?type=admin'">
                        <i class="fas fa-user-shield"></i> Send to Admin
                    </button>
                </div>

                <form action="/tutor-send-message" method="post" class="compose-form">
                    <input type="hidden" name="message_type" value="<?= htmlspecialchars($messageType) ?>">
                    
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                    
                    <?php if ($messageType === 'student'): ?>
                    <div class="recipient-section">
                        <label for="students">Select Students:</label>
                        <select id="students" name="students[]" multiple class="select2" required>
                            <?php foreach ($students as $student): ?>
                                <option value="<?= $student['student_id'] ?>" <?= (isset($selectedRecipient) && $messageType === 'student' && $selectedRecipient == $student['student_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($student['student_first_name'] . ' ' . $student['student_last_name']) ?> (#<?= $student['student_id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <?php if ($messageType === 'admin'): ?>
                    <div class="recipient-section">
                        <label for="admins">Select Admin:</label>
                        <select id="admins" name="admins[]" multiple class="select2" required>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?= $admin['admin_id'] ?>" <?= (isset($selectedRecipient) && $messageType === 'admin' && $selectedRecipient == $admin['admin_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($admin['username']) ?> (#<?= $admin['admin_id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select recipients",
                allowClear: true
            });
        });
    </script>
</body>
</html>