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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <style>
        
        .compose-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px 0;
            width: 60%;
            align-self: center;
            margin-left:15%;
            font-family:'poppins', sans-serif !important;
            border: 2px solid var(--dark-blue);
        }
        
        .message-type-tabs {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
            font-family:'poppins', sans-serif !important;
        }
        
        .message-type-tab {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            background-color: transparent;
            font-size: 16px;
            color: #555;
            font-family:'poppins', sans-serif !important;        
        }
        
        .message-type-tab.active {
            border-bottom: 3px solid var(--dark-blue);
            color: #4c59a6;
            font-weight: bold;
        }
        
        .compose-form {
            margin-top: 10px;
        }
        
        .compose-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        
        .compose-form input[type="text"],
        .compose-form textarea,
        .compose-form select {
            width: 80%;
            padding: 10px;
            margin-bottom: 10px;
            border: 2px solid var(--dark-blue);
            border-radius: 5px;
            font-size: 12px;
            font-family:'poppins', sans-serif !important;
        }
        
        .compose-form textarea {
            height: 200px;
            resize: vertical;
        }
        
        .compose-form button {
            background-color: #4c59a6;
            color: white;
            border: none;
            padding: 5px 20px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            font-family:'poppins', sans-serif !important;

        }
        
        .compose-form button:hover {
            background-color: var(--dark-blue);
        }
        
        .compose-form button[type="reset"] {
            background-color: var(--dark-pink);
            color: #333;
            margin-right: 10px;
        }
        
        .compose-form button[type="reset"]:hover {
            background-color: var(--dark-pink);
        }
        
        .form-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        
        .recipient-section {
            margin-bottom: 20px;
        }
        
        .select2-container {
            width: 100% !important;
        }
        
        @media screen and (max-width: 768px) {
            .compose-container {
                padding: 15px;
            }
            
            .message-type-tab {
                padding: 8px 15px;
                font-size: 14px;
            }
        }
    </style>
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
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select recipients',
                allowClear: true
            });
        });
    </script>
</body>
</html>