<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Upgrade Request Details</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .detail-container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link i {
            margin-right: 5px;
        }
        
        .request-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .tutor-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid #f5f5f5;
        }
        
        .tutor-info h2 {
            margin: 0 0 5px 0;
            color: #333;
        }
        
        .tutor-info p {
            margin: 0 0 5px 0;
            color: #666;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: white;
            background-color: #f39c12;
            margin-top: 5px;
        }
        
        .detail-section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .section-header {
            background-color: #f5f5f5;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }
        
        .section-header h3 {
            margin: 0;
            color: #333;
            font-size: 16px;
        }
        
        .section-content {
            padding: 20px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 15px;
        }
        
        .detail-label {
            font-weight: 500;
            width: 180px;
            color: #555;
        }
        
        .detail-value {
            flex: 1;
            color: #333;
        }
        
        .level-badges {
            display: flex;
            gap: 15px;
            align-items: center;
            margin: 10px 0;
        }
        
        .level-badge {
            padding: 8px 15px;
            border-radius: 20px;
            color: white;
            font-weight: 500;
        }
        
        .current-level {
            background-color: #3498db;
        }
        
        .requested-level {
            background-color: #9b59b6;
        }
        
        .level-arrow {
            color: #666;
            font-size: 18px;
            margin: 0 5px;
        }
        
        .request-message {
            background-color: #f9f9f9;
            border-left: 4px solid #9b59b6;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 5px 5px 0;
            font-style: italic;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: flex-end;
        }
        
        .action-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .approve-btn {
            background-color: #2ecc71;
        }
        
        .approve-btn:hover {
            background-color: #27ae60;
        }
        
        .reject-btn {
            background-color: #e74c3c;
        }
        
        .reject-btn:hover {
            background-color: #c0392b;
        }
        
        .custom-level {
            margin-top: 20px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
        
        .custom-level h4 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #333;
        }
        
        .custom-level p {
            margin-bottom: 15px;
            color: #666;
        }
        
        .custom-level select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        
        .custom-level-submit {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .custom-level-submit:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <div class="admin-dashboard detail-container">
            <a href="/admin-tutor-upgrade-requests" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Upgrade Requests
            </a>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="alert-message alert-success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert-message alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($request) && $request): ?>
                <div class="request-header">
                    <img src="/images/tutor_uploads/tutor_profile_photos/<?= !empty($request['tutor_profile_photo']) ? htmlspecialchars($request['tutor_profile_photo']) : 'default.jpg' ?>" alt="Tutor Photo" class="tutor-photo">
                    <div class="tutor-info">
                        <h2><?= htmlspecialchars($request['tutor_first_name'] . ' ' . $request['tutor_last_name']) ?></h2>
                        <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($request['tutor_email']) ?></p>
                        <p><i class="fas fa-id-card"></i> Tutor ID: <?= htmlspecialchars($request['tutor_id']) ?></p>
                        <span class="status-badge">
                            <i class="fas fa-clock"></i> Pending Review
                        </span>
                    </div>
                </div>
                
                <div class="detail-section">
                    <div class="section-header">
                        <h3><i class="fas fa-info-circle"></i> Request Details</h3>
                    </div>
                    <div class="section-content">
                        <div class="detail-row">
                            <div class="detail-label">Request ID:</div>
                            <div class="detail-value"><?= htmlspecialchars($request['request_id']) ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Request Date:</div>
                            <div class="detail-value"><?= htmlspecialchars($request['request_date']) ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tutor Level:</div>
                            <div class="detail-value">
                                <div class="level-badges">
                                    <span class="level-badge current-level">
                                        <i class="fas fa-user-graduate"></i> Current: <?= htmlspecialchars($request['current_level_id']) ?>
                                    </span>
                                    <span class="level-arrow"><i class="fas fa-long-arrow-alt-right"></i></span>
                                    <span class="level-badge requested-level">
                                        <i class="fas fa-level-up-alt"></i> Requested: <?= htmlspecialchars($request['requested_level_id']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status:</div>
                            <div class="detail-value"><?= htmlspecialchars(ucfirst($request['status'])) ?></div>
                        </div>
                        <?php if (!empty($request['status_updated_date'])): ?>
                        <div class="detail-row">
                            <div class="detail-label">Status Updated:</div>
                            <div class="detail-value"><?= htmlspecialchars($request['status_updated_date']) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="detail-section">
                    <div class="section-header">
                        <h3><i class="fas fa-comment-alt"></i> Request Message</h3>
                    </div>
                    <div class="section-content">
                        <?php if (!empty($request['request_body'])): ?>
                            <div class="request-message">
                                "<?= nl2br(htmlspecialchars($request['request_body'])) ?>"
                            </div>
                        <?php else: ?>
                            <p>No additional message provided with this request.</p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($request['status'] == 'pending'): ?>
                <div class="detail-section">
                    <div class="section-header">
                        <h3><i class="fas fa-tasks"></i> Actions</h3>
                    </div>
                    <div class="section-content">
                        <div class="custom-level">
                            <h4>Custom Level Assignment</h4>
                            <p>Optionally assign a level different from the requested one:</p>
                            <form action="/admin-approve-upgrade/<?= htmlspecialchars($request['request_id']) ?>" method="POST">
                                <select name="custom_level" id="custom_level">
                                    <option value="">Use requested level (<?= htmlspecialchars($request['requested_level_id']) ?>)</option>
                                    <?php foreach ($levels as $level): ?>
                                        <option value="<?= htmlspecialchars($level['tutor_level_id']) ?>"><?= htmlspecialchars($level['tutor_level_id']) ?> - <?= htmlspecialchars($level['tutor_level_name'] ?? '') ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="custom-level-submit">Approve with Custom Level</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert-message alert-error">
                    <i class="fas fa-exclamation-triangle"></i> Upgrade request not found or has been deleted.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function confirmApprove() {
            return confirm('Are you sure you want to approve this tutor upgrade request?');
        }
        
        function confirmReject() {
            return confirm('Are you sure you want to reject this tutor upgrade request?');
        }
    </script>
</body>
</html>