<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/AdminSettings.css">
    <style>
        
    </style>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    <div class="main">
        <div class="dashboard-container">
            <form id="settings-form" action="/admin-settings" method="post">
                <div class="settings-container">
                    <!-- User Management Section -->
                    <div class="settings-section">
                        <h2>User Management</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <label class="switch">
                                <?php
                                    $tutorRegistrationEnabled = isset($adminTutorRegistration['admin_setting_value']) ? 
                                        $adminTutorRegistration['admin_setting_value'] : false;

                                    if($tutorRegistrationEnabled == true) {
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
                                    $studentRegistrationEnabled = isset($adminStudentRegistration['admin_setting_value']) ? 
                                        $adminStudentRegistration['admin_setting_value'] : false;

                                    if($studentRegistrationEnabled == true) {
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
                        </div>
                    </div>

                    <!-- Session Settings Section -->
                    <div class="settings-section">
                        <h2>Session Settings</h2>
                        <div class="settings-grid">
                            <div class="setting-item">
                                <select name="session_duration" class="select-input">
                                    <option value="60">60 Minutes</option>
                                    <option value="90">90 Minutes</option>
                                    <option value="120">120 Minutes</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Default Session Duration</h4>
                                    <p>Standard session length</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <select name="booking_window" class="select-input">
                                    <option value="7">1 Week</option>
                                    <option value="14">2 Weeks</option>
                                    <option value="30">1 Month</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Booking Window</h4>
                                    <p>Advance booking period</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <select name="cancellation_window" class="select-input">
                                    <option value="24">24 Hours</option>
                                    <option value="12">12 Hours</option>
                                    <option value="6">6 Hours</option>
                                    <option value="3">3 Hours</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Cancellation Policy</h4>
                                    <p>Minimum notice for cancellation</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <select name="noshow_penalty" class="select-input">
                                    <option value="none">No Penalty</option>
                                    <option value="fee">Cancellation Fee</option>
                                    <option value="warning">Warning System</option>
                                    <option value="full">Full Charge</option>
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
                                    <input type="checkbox" name="email_notifications" checked>
                                    <span class="slider"></span>
                                </label>
                                <div class="setting-info">
                                    <h4>Email Notifications</h4>
                                    <p>Send booking confirmations</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <select name="reminder_time" class="select-input">
                                    <option value="1">1 Hour Before</option>
                                    <option value="24">24 Hours Before</option>
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
                                <select name="payout_schedule" class="select-input">
                                    <option value="7">Weekly</option>
                                    <option value="14">Bi-weekly</option>
                                    <option value="30">Monthly</option>
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
                                    $contentApprovalRequired = isset($adminContentApproval['admin_setting_value']) ? 
                                        $adminContentApproval['admin_setting_value'] : true;

                                    if($contentApprovalRequired == true) {
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
                                <select name="allowed_file_types" class="select-input" multiple>
                                    <option value="pdf">PDF</option>
                                    <option value="doc">Word Documents</option>
                                    <option value="image">Images</option>
                                    <option value="video">Videos</option>
                                    <option value="audio">Audio</option>
                                    <option value="ppt">Presentations</option>
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
                                <select name="theme" class="select-input">
                                    <option value="light">Light Mode</option>
                                    <option value="dark">Dark Mode</option>
                                    <option value="system">Follow System Preference</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Default Theme</h4>
                                    <p>Platform visual appearance</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <input type="file" name="custom_logo" class="file-input" accept="image/*">
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
                                <select name="video_platform" class="select-input">
                                    <option value="zoom">Zoom</option>
                                    <option value="teams">Microsoft Teams</option>
                                    <option value="meet">Google Meet</option>
                                    <option value="webrtc">Built-in WebRTC</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Video Conferencing</h4>
                                    <p>Platform for virtual sessions</p>
                                </div>
                            </div>
                            
                            <div class="setting-item">
                                <select name="calendar_integration" class="select-input">
                                    <option value="none">None</option>
                                    <option value="google">Google Calendar</option>
                                    <option value="outlook">Microsoft Outlook</option>
                                    <option value="apple">Apple Calendar</option>
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
</body>
</html>