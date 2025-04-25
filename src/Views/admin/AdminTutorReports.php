<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Tutor Reports</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/AdminInbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <br>
        <div class="admin-dashboard">
        
        <div class="inbox-tabs">
            <a href="/admin-inbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'inbox') ? 'active' : '' ?>">Inbox
            <?php if ($unreadCount > 0): ?>
                <i class="fa-solid fa-circle-exclamation" style="margin:0;"></i>
            <?php endif; ?>
            </a>
            <a href="/admin-inbox?status=archived" class="tab-link <?= (isset($activeTab) && $activeTab === 'archived') ? 'active' : '' ?>">Archived</a>
            <a href="/admin-compose-message" class="tab-link <?= (isset($activeTab) && $activeTab === 'compose') ? 'active' : '' ?>">Compose</a>
            <a href="/admin-outbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'outbox') ? 'active' : '' ?>">Outbox</a>
            <a href="/admin-tutor-reports" class="tab-link <?= (isset($activeTab) && $activeTab === 'reports') ? 'active' : '' ?>">Tutor Reports</a>
        </div>
            
            <form method="POST" class="search-form" action="/admin-tutor-reports">
                <div class="searchbar">
                    <input type="text" name="search_term" placeholder="Search reports..." value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                    <button type="submit" name="search">Search</button>
                </div>
            </form>
            
            <div class="inbox-container">
                <div class="inbox-sidebar">
                    <div class="status-filter">
                        <label>Filter:</label>
                        <select name="filter" onchange="window.location.href = this.value">
                            <option value="/admin-tutor-reports" <?= !isset($_GET['filter']) ? 'selected' : '' ?>>All Issues</option>
                            <option value="/admin-tutor-reports?filter=missed-class" <?= isset($_GET['filter']) && $_GET['filter'] === 'missed-class' ? 'selected' : '' ?>>Missed Classes</option>
                            <option value="/admin-tutor-reports?filter=misconduct" <?= isset($_GET['filter']) && $_GET['filter'] === 'misconduct' ? 'selected' : '' ?>>Misconduct</option>
                            <option value="/admin-tutor-reports?filter=payment" <?= isset($_GET['filter']) && $_GET['filter'] === 'payment' ? 'selected' : '' ?>>Payment Issues</option>
                            <option value="/admin-tutor-reports?filter=technical" <?= isset($_GET['filter']) && $_GET['filter'] === 'technical' ? 'selected' : '' ?>>Technical Issues</option>
                        </select>
                    </div>
                    
                    <?php if (!empty($reports)): ?>
                        <?php foreach ($reports as $report): ?>
                            <div class="message-item <?= isset($activeReport) && $activeReport['report_id'] == $report['report_id'] ? 'active' : '' ?>"
                                 onclick="window.location.href='/admin-tutor-report/<?= $report['report_id'] ?>'">
                                <div class="message-subject"><?= htmlspecialchars($report['issue_type']) ?></div>
                                <div class="message-sender">
                                    Tutor: <?= htmlspecialchars($report['tutor_first_name'] . ' ' . $report['tutor_last_name']) ?> (#<?= htmlspecialchars($report['tutor_id']) ?>)
                                </div>
                                <div class="message-preview"><?= htmlspecialchars(substr($report['description'], 0, 60) . (strlen($report['description']) > 60 ? '...' : '')) ?></div>
                                <div class="message-date"><?= htmlspecialchars(date('M d, Y', strtotime($report['report_time']))) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-regular fa-clipboard"></i>
                            <p>No reports found</p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($totalPages > 1): ?>
                        <div class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>" 
                                   class="<?= $currentPage == $i ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="inbox-content">
                    <?php if (isset($activeReport)): ?>
                        <div class="message-header">
                            <h3 class="message-subject-header"><?= htmlspecialchars($activeReport['issue_type']) ?></h3>
                            <div class="message-info">
                                <span>Tutor: <?= htmlspecialchars($activeReport['tutor_first_name'] . ' ' . $activeReport['tutor_last_name']) ?> (#<?= htmlspecialchars($activeReport['tutor_id']) ?>)</span>
                                <span>Student: <?= htmlspecialchars($activeReport['student_first_name'] . ' ' . $activeReport['student_last_name']) ?> (#<?= htmlspecialchars($activeReport['student_id']) ?>)</span>
                                <span><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($activeReport['report_time']))) ?></span>
                            </div>
                        </div>
                        <div class="message-body">
                            <?= nl2br(htmlspecialchars($activeReport['description'])) ?>
                        </div>
                        <div class="action-buttons">
                            <button class="tab-link active" onclick="window.location.href='/admin-compose-message?type=student&recipient=<?= $activeReport['student_id'] ?>'">Message Student</button>
                            <button class="tab-link active" onclick="window.location.href='/admin-compose-message?type=tutor&recipient=<?= $activeReport['tutor_id'] ?>'">Message Tutor</button>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-regular fa-clipboard"></i>
                            <p>Select a report to view details</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>