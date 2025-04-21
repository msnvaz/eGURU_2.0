<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Upgrade Request Details</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/AdminTutorUpgradeRequestDetails.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <div class="admin-dashboard detail-container">       
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
                                
                <div class="detail-section">
                    <div class="section-header">
                        <h3><i class="fas fa-info-circle"></i> Request Details</h3>
                    </div>
                    <div class="section-content">
                        <div class="detail-row">
                            <div class="detail-label">Request ID:</div>
                            <div class="detail-value"><?= htmlspecialchars($request['request_id']) ?></div>
                        </div>
                        <div class="detail-row" >
                            <div class="detail-label">Request Date:</div>
                            <div class="detail-value"><?= htmlspecialchars($request['request_date']) ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-value">
                                <div class="level-badges" style="justify-content: center;">
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