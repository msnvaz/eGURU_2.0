<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Compose Message</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/AdminInbox.css">
    <link rel="stylesheet" href="/css/admin/AdminComposeMessage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <br>
        <div class="admin-dashboard">
        <div class="inbox-tabs">
            <a href="/admin-inbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'inbox') ? 'active' : '' ?>">Inbox</a>
            <a href="/admin-inbox?status=archived" class="tab-link <?= (isset($activeTab) && $activeTab === 'archived') ? 'active' : '' ?>">Archived</a>
            <a href="/admin-compose-message" class="tab-link <?= (isset($activeTab) && $activeTab === 'compose') ? 'active' : '' ?>">Compose</a>
            <a href="/admin-outbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'outbox') ? 'active' : '' ?>">Outbox</a>
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
                
                <div class="message-type-tabs">
                    <button class="message-type-tab <?= $messageType === 'student' ? 'active' : '' ?>" onclick="window.location.href='/admin-compose-message?type=student'">
                        <i class="fas fa-user-graduate"></i> Send to Students
                    </button>
                    <button class="message-type-tab <?= $messageType === 'tutor' ? 'active' : '' ?>" onclick="window.location.href='/admin-compose-message?type=tutor'">
                        <i class="fas fa-chalkboard-teacher"></i> Send to Tutors
                    </button>
                    <button class="message-type-tab <?= $messageType === 'both' ? 'active' : '' ?>" onclick="window.location.href='/admin-compose-message?type=both'">
                        <i class="fas fa-users"></i> Send to Both
                    </button>
                </div>

                <form action="/admin-send-message" method="post" class="compose-form">
                    <input type="hidden" name="message_type" value="<?= htmlspecialchars($messageType) ?>">
                    
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                    
                    <?php if ($messageType === 'student' || $messageType === 'both'): ?>
                    <div class="recipient-section">
                        <label for="students">Select Students:</label>
                        <select id="students" name="students[]" multiple class="select2" <?= $messageType === 'student' || $messageType === 'both' ? 'required' : '' ?>>
                            <?php foreach ($students as $student): ?>
                                <option value="<?= $student['student_id'] ?>">
                                    <?= htmlspecialchars($student['student_first_name'] . ' ' . $student['student_last_name']) ?> (ID: <?= $student['student_id'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($messageType === 'tutor' || $messageType === 'both'): ?>
                    <div class="recipient-section">
                        <label for="tutors">Select Tutors:</label>
                        <select id="tutors" name="tutors[]" multiple class="select2" <?= $messageType === 'tutor' || $messageType === 'both' ? 'required' : '' ?>>
                            <?php foreach ($tutors as $tutor): ?>
                                <option value="<?= $tutor['tutor_id'] ?>">
                                    <?= htmlspecialchars($tutor['tutor_first_name'] . ' ' . $tutor['tutor_last_name']) ?> (ID: <?= $tutor['tutor_id'] ?>)
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
</body>
</html>