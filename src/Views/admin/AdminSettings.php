<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    <div class="main">
        <div class="dashboard-container">
            <form id="settings-form" action="/admin-settings" method="post">
                <!-- Settings Sections -->
                <div class="settings-grid">
                    <!-- User Management -->
                    <div class="settings-card">
                        <h2>User Management</h2>
                        <div class="settings-content">
                        <div class="setting-item">
                                <label class="switch">
                                <?php
                                    // Ensure variable exists before accessing
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

                            <!-- student registration switch as a separate item -->
                            <div class="setting-item">
                                <label class="switch">
                                <?php
                                    // Ensure variable exists before accessing
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
                                    <p>Allow new tutors to register</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Settings -->
                    <div class="settings-card">
                        <h2>Session Settings</h2>
                        <div class="settings-content">
                            <div class="setting-item">
                                <select name="session_duration" class="select-input">
                                    <option value="60">60 Minutes</option>
                                    <option value="90">90 Minutes</option>
                                    <option value="120">120 Minutes</option>
                                </select>
                                <div class="setting-info">
                                    <h4>Default Duration</h4>
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
                        </div>
                    </div>

                    <!-- Notification Settings -->
                    <div class="settings-card">
                        <h2>Notifications</h2>
                        <div class="settings-content">
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

                    <!-- Payment Settings -->
                    <div class="settings-card">
                        <h2>Payment Settings</h2>
                        <div class="settings-content">
                        <div class="setting-item">
                            <?php
                                // Ensure variable exists before accessing
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
                </div>
                <!-- Save Button -->
                <button type="submit" class="floating-btn">Save Settings</button>
            </form>
        </div>
    </div>
</body>
</html>
