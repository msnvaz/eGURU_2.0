<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Settings</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/AdminSettings.css">
    <style>
        /* Success message styling */
        .message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    <div class="main">
        <div class="dashboard-container">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="message">
                    <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>
            
            <form id="settings-form" action="/admin-settings" method="post" enctype="multipart/form-data">
                <div class="settings-container">
                    <!-- User Management Section -->
                    <div class="settings-section">
                        <h2>User Management</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <label class="switch">
                                <?php
                                    $tutorRegistrationEnabled = isset($adminTutorRegistration['admin_setting_value']) && 
                                        $adminTutorRegistration['admin_setting_value'] == 1;

                                    if($tutorRegistrationEnabled) {
                                        echo '<input type="checkbox" name="tutor_registration" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="tutor_registration">';
                                    }
                                ?>
                                    <span class="slider"></span>
                                </label>
                                <div class="setting-info">
                                    <h4>Tutor Registration</h4>
                                    <p>Allow new tutors to register</p>
                                </div>
                            </div>

                            <div class="setting-item">
                                <label class="switch">
                                <?php
                                    $studentRegistrationEnabled = isset($adminStudentRegistration['admin_setting_value']) && 
                                        $adminStudentRegistration['admin_setting_value'] == 1;

                                    if($studentRegistrationEnabled) {
                                        echo '<input type="checkbox" name="student_registration" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="student_registration">';
                                    }
                                ?>
                                    <span class="slider"></span>
                                </label>
                                <div class="setting-info">
                                    <h4>Student Registration</h4>
                                    <p>Allow new students to register</p>
                                </div>
                            </div>
                            
                            <!-- Security Settings -->
                            <div class="setting-item">
                                <label class="switch">
                                <?php
                                    $require2faEnabled = isset($require_2fa['admin_setting_value']) && 
                                        $require_2fa['admin_setting_value'] == 1;

                                    if($require2faEnabled) {
                                        echo '<input type="checkbox" name="require_2fa" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="require_2fa">';
                                    }
                                ?>
                                    <span class="slider"></span>
                                </label>
                                <div class="setting-info">
                                    <h4>Require 2FA</h4>
                                    <p>Two-factor authentication for all users</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $passwordPolicy = isset($password_policy['admin_setting_value']) ? 
                                        $password_policy['admin_setting_value'] : 'basic';
                                ?>
                                <select name="password_policy" class="select-input">
                                    <option value="basic" <?= $passwordPolicy == 'basic' ? 'selected' : '' ?>>Basic</option>
                                    <option value="medium" <?= $passwordPolicy == 'medium' ? 'selected' : '' ?>>Medium</option>
                                    <option value="strong" <?= $passwordPolicy == 'strong' ? 'selected' : '' ?>>Strong</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Password Policy</h4>
                                    <p>Password security requirements</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $sessionTimeout = isset($session_timeout['admin_setting_value']) ? 
                                        $session_timeout['admin_setting_value'] : 30;
                                ?>
                                <select name="session_timeout" class="select-input">
                                    <option value="15" <?= $sessionTimeout == 15 ? 'selected' : '' ?>>15 Minutes</option>
                                    <option value="30" <?= $sessionTimeout == 30 ? 'selected' : '' ?>>30 Minutes</option>
                                    <option value="60" <?= $sessionTimeout == 60 ? 'selected' : '' ?>>60 Minutes</option>
                                    <option value="120" <?= $sessionTimeout == 120 ? 'selected' : '' ?>>120 Minutes</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Session Timeout</h4>
                                    <p>Auto logout after inactivity</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Settings Section -->
                    <div class="settings-section">
                        <h2>Session Settings</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <?php
                                    $defaultDuration = isset($default_duration['admin_setting_value']) ? 
                                        $default_duration['admin_setting_value'] : 60;
                                ?>
                                <select name="default_duration" class="select-input">
                                    <option value="60" <?= $defaultDuration == 60 ? 'selected' : '' ?>>60 Minutes</option>
                                    <option value="90" <?= $defaultDuration == 90 ? 'selected' : '' ?>>90 Minutes</option>
                                    <option value="120" <?= $defaultDuration == 120 ? 'selected' : '' ?>>120 Minutes</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Default Session Duration</h4>
                                    <p>Standard session length</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $bookingWindow = isset($booking_window['admin_setting_value']) ? 
                                        $booking_window['admin_setting_value'] : 7;
                                ?>
                                <select name="booking_window" class="select-input">
                                    <option value="7" <?= $bookingWindow == 7 ? 'selected' : '' ?>>1 Week</option>
                                    <option value="14" <?= $bookingWindow == 14 ? 'selected' : '' ?>>2 Weeks</option>
                                    <option value="30" <?= $bookingWindow == 30 ? 'selected' : '' ?>>1 Month</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Booking Window</h4>
                                    <p>Advance booking period</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $cancellationWindow = isset($cancellation_window['admin_setting_value']) ? 
                                        $cancellation_window['admin_setting_value'] : 24;
                                ?>
                                <select name="cancellation_window" class="select-input">
                                    <option value="24" <?= $cancellationWindow == 24 ? 'selected' : '' ?>>24 Hours</option>
                                    <option value="12" <?= $cancellationWindow == 12 ? 'selected' : '' ?>>12 Hours</option>
                                    <option value="6" <?= $cancellationWindow == 6 ? 'selected' : '' ?>>6 Hours</option>
                                    <option value="3" <?= $cancellationWindow == 3 ? 'selected' : '' ?>>3 Hours</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Cancellation Policy</h4>
                                    <p>Minimum notice for cancellation</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $noShowPenalty = isset($noshow_penalty['admin_setting_value']) ? 
                                        $noshow_penalty['admin_setting_value'] : 'none';
                                ?>
                                <select name="noshow_penalty" class="select-input">
                                    <option value="none" <?= $noShowPenalty == 'none' ? 'selected' : '' ?>>No Penalty</option>
                                    <option value="fee" <?= $noShowPenalty == 'fee' ? 'selected' : '' ?>>Cancellation Fee</option>
                                    <option value="warning" <?= $noShowPenalty == 'warning' ? 'selected' : '' ?>>Warning System</option>
                                    <option value="full" <?= $noShowPenalty == 'full' ? 'selected' : '' ?>>Full Charge</option>
                                </select>
                                <div class="setting-info">
                                    <h4>No-Show Penalty</h4>
                                    <p>Consequences for missed sessions</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notification Settings Section -->
                    <div class="settings-section">
                        <h2>Notifications</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <label class="switch">
                                <?php
                                    $emailNotificationsEnabled = isset($email_notifications['admin_setting_value']) && 
                                        $email_notifications['admin_setting_value'] == 1;

                                    if($emailNotificationsEnabled) {
                                        echo '<input type="checkbox" name="email_notifications" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="email_notifications">';
                                    }
                                ?>
                                    <span class="slider"></span>
                                </label>
                                <div class="setting-info">
                                    <h4>Email Notifications</h4>
                                    <p>Send booking confirmations</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $reminderTime = isset($reminder_time['admin_setting_value']) ? 
                                        $reminder_time['admin_setting_value'] : 24;
                                ?>
                                <select name="reminder_time" class="select-input">
                                    <option value="1" <?= $reminderTime == 1 ? 'selected' : '' ?>>1 Hour Before</option>
                                    <option value="24" <?= $reminderTime == 24 ? 'selected' : '' ?>>24 Hours Before</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Session Reminders</h4>
                                    <p>When to send reminders</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Settings Section -->
                    <div class="settings-section">
                        <h2>Payment Settings</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <?php
                                    $platformFee = isset($adminPlatformFee['admin_setting_value']) ? 
                                        $adminPlatformFee['admin_setting_value'] : 5;
                                ?>
                                <input type="number" name="platform_fee" class="number-input" value="<?php echo htmlspecialchars($platformFee); ?>" min="0" max="100">
                                <div class="setting-info">
                                    <h4>Platform Fee (%)</h4>
                                    <p>Commission per booking</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $payoutSchedule = isset($payout_schedule['admin_setting_value']) ? 
                                        $payout_schedule['admin_setting_value'] : 7;
                                ?>
                                <select name="payout_schedule" class="select-input">
                                    <option value="7" <?= $payoutSchedule == 7 ? 'selected' : '' ?>>Weekly</option>
                                    <option value="14" <?= $payoutSchedule == 14 ? 'selected' : '' ?>>Bi-weekly</option>
                                    <option value="30" <?= $payoutSchedule == 30 ? 'selected' : '' ?>>Monthly</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Payout Schedule</h4>
                                    <p>Teacher payment frequency</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content Management Section -->
                    <div class="settings-section">
                        <h2>Content Management</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <label class="switch">
                                <?php
                                    $contentApprovalRequired = isset($adminContentApproval['admin_setting_value']) && 
                                        $adminContentApproval['admin_setting_value'] == 1;

                                    if($contentApprovalRequired) {
                                        echo '<input type="checkbox" name="content_approval" checked>';
                                    } else {
                                        echo '<input type="checkbox" name="content_approval">';
                                    }
                                ?>
                                    <span class="slider"></span>
                                </label>
                                <div class="setting-info">
                                    <h4>Content Approval</h4>
                                    <p>Require approval for tutor uploads</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $maxFileSize = isset($adminMaxFileSize['admin_setting_value']) ? 
                                        $adminMaxFileSize['admin_setting_value'] : 10;
                                ?>
                                <input type="number" name="max_file_size" class="number-input" value="<?php echo htmlspecialchars($maxFileSize); ?>" min="1" max="100">
                                <div class="setting-info">
                                    <h4>Max File Size (MB)</h4>
                                    <p>File upload size limit</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $allowedFileTypes = isset($allowed_file_types['admin_setting_value']) ? 
                                        explode(',', $allowed_file_types['admin_setting_value']) : ['pdf', 'doc', 'image'];
                                ?>
                                <select name="allowed_file_types[]" class="select-input" multiple>
                                    <option value="pdf" <?= in_array('pdf', $allowedFileTypes) ? 'selected' : '' ?>>PDF</option>
                                    <option value="doc" <?= in_array('doc', $allowedFileTypes) ? 'selected' : '' ?>>Word Documents</option>
                                    <option value="image" <?= in_array('image', $allowedFileTypes) ? 'selected' : '' ?>>Images</option>
                                    <option value="video" <?= in_array('video', $allowedFileTypes) ? 'selected' : '' ?>>Videos</option>
                                    <option value="audio" <?= in_array('audio', $allowedFileTypes) ? 'selected' : '' ?>>Audio</option>
                                    <option value="ppt" <?= in_array('ppt', $allowedFileTypes) ? 'selected' : '' ?>>Presentations</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Allowed File Types</h4>
                                    <p>File formats for course materials</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Platform Appearance Section -->
                    <div class="settings-section">
                        <h2>Platform Appearance</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <?php
                                    $selectedTheme = isset($theme['admin_setting_value']) ? 
                                        $theme['admin_setting_value'] : 'light';
                                ?>
                                <select name="theme" class="select-input">
                                    <option value="light" <?= $selectedTheme == 'light' ? 'selected' : '' ?>>Light Mode</option>
                                    <option value="dark" <?= $selectedTheme == 'dark' ? 'selected' : '' ?>>Dark Mode</option>
                                    <option value="system" <?= $selectedTheme == 'system' ? 'selected' : '' ?>>Follow System Preference</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Default Theme</h4>
                                    <p>Platform visual appearance</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <input type="file" name="custom_logo" class="file-input" accept="image/*">
                                <?php if (!empty($custom_logo['admin_setting_value'])): ?>
                                <div class="current-logo">
                                    <p>Current Logo:</p>
                                    <img src="<?php echo htmlspecialchars($custom_logo['admin_setting_value']); ?>" alt="Current Logo" style="max-width: 150px; max-height: 60px;">
                                </div>
                                <?php endif; ?>
                                <div class="setting-info">
                                    <h4>Custom Logo</h4>
                                    <p>Upload your platform logo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Integration Settings Section -->
                    <div class="settings-section">
                        <h2>Integration Settings</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <?php
                                    $selectedVideoPlatform = isset($video_platform['admin_setting_value']) ? 
                                        $video_platform['admin_setting_value'] : 'zoom';
                                ?>
                                <select name="video_platform" class="select-input">
                                    <option value="zoom" <?= $selectedVideoPlatform == 'zoom' ? 'selected' : '' ?>>Zoom</option>
                                    <option value="teams" <?= $selectedVideoPlatform == 'teams' ? 'selected' : '' ?>>Microsoft Teams</option>
                                    <option value="meet" <?= $selectedVideoPlatform == 'meet' ? 'selected' : '' ?>>Google Meet</option>
                                    <option value="webrtc" <?= $selectedVideoPlatform == 'webrtc' ? 'selected' : '' ?>>Built-in WebRTC</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Video Conferencing</h4>
                                    <p>Platform for virtual sessions</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <?php
                                    $selectedCalendar = isset($calendar_integration['admin_setting_value']) ? 
                                        $calendar_integration['admin_setting_value'] : 'none';
                                ?>
                                <select name="calendar_integration" class="select-input">
                                    <option value="none" <?= $selectedCalendar == 'none' ? 'selected' : '' ?>>None</option>
                                    <option value="google" <?= $selectedCalendar == 'google' ? 'selected' : '' ?>>Google Calendar</option>
                                    <option value="outlook" <?= $selectedCalendar == 'outlook' ? 'selected' : '' ?>>Microsoft Outlook</option>
                                    <option value="apple" <?= $selectedCalendar == 'apple' ? 'selected' : '' ?>>Apple Calendar</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Calendar Integration</h4>
                                    <p>Sync sessions with calendars</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Save Button -->
                <button type="submit" class="floating-btn">Save Settings</button>
            </form>
        </div>
    </div>
    
    <script>
        // Add client-side validation and confirmation
        document.getElementById('settings-form').addEventListener('submit', function(e) {
            // You could add validation here if needed
            
            // Ensure multiple select values are properly selected
            var fileTypesSelect = document.querySelector('select[name="allowed_file_types[]"]');
            if (fileTypesSelect.selectedOptions.length === 0) {
                e.preventDefault();
                alert('Please select at least one allowed file type.');
            }
        });
    </script>
</body>
</html>