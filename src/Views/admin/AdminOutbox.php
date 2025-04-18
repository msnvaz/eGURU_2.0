<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Outbox</title>
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
            <a href="/admin-inbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'inbox') ? 'active' : '' ?>">Inbox</a>
            <a href="/admin-inbox?status=archived" class="tab-link <?= (isset($activeTab) && $activeTab === 'archived') ? 'active' : '' ?>">Archived</a>
            <a href="/admin-compose-message" class="tab-link <?= (isset($activeTab) && $activeTab === 'compose') ? 'active' : '' ?>">Compose</a>
            <a href="/admin-outbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'outbox') ? 'active' : '' ?>">Outbox</a>
        </div>
            
            <form method="POST" class="search-form" action="/admin-outbox">
                <div class="searchbar">
                    <input type="text" name="search_term" placeholder="Search sent messages..." value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                    <button type="submit" name="search">Search</button>
                </div>
            </form>
            
            <div class="inbox-container">
                <div class="inbox-sidebar">
                    <div class="status-filter">
                        <label>Filter:</label>
                        <select name="filter" onchange="window.location.href = this.value">
                            <option value="/admin-outbox" <?= !isset($_GET['filter']) ? 'selected' : '' ?>>All</option>
                            <option value="/admin-outbox?filter=student" <?= isset($_GET['filter']) && $_GET['filter'] === 'student' ? 'selected' : '' ?>>To Students</option>
                            <option value="/admin-outbox?filter=tutor" <?= isset($_GET['filter']) && $_GET['filter'] === 'tutor' ? 'selected' : '' ?>>To Tutors</option>
                        </select>
                    </div>
                    
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="message-item <?= isset($activeMessage) && $activeMessage['message_id'] == $message['message_id'] && $activeMessage['recipient_type'] == $message['recipient_type'] ? 'active' : '' ?>" 
                                 onclick="window.location.href='/admin-outbox-message/<?= $message['message_id'] ?>/<?= $message['recipient_type'] ?>'">
                                <div class="message-subject"><?= htmlspecialchars($message['subject']) ?></div>
                                <div class="message-sender">
                                    To: <?= htmlspecialchars($message['recipient_type'] === 'student' ? 'Student' : 'Tutor') ?> <?= isset($message['recipient_name']) ? htmlspecialchars($message['recipient_name']) : '#' . htmlspecialchars($message['recipient_id']) ?>
                                </div>
                                <div class="message-preview"><?= htmlspecialchars(substr($message['message'], 0, 60) . (strlen($message['message']) > 60 ? '...' : '')) ?></div>
                                <div class="message-date"><?= htmlspecialchars(date('M d, Y', strtotime($message['sent_at']))) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-regular fa-paper-plane"></i>
                            <p>No sent messages found</p>
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
                    <?php if (isset($activeMessage)): ?>
                        <div class="message-header">
                            <h3 class="message-subject-header"><?= htmlspecialchars($activeMessage['subject']) ?></h3>
                            <div class="message-info">
                                <span>To: <?= htmlspecialchars($activeMessage['recipient_type'] === 'student' ? 'Student' : 'Tutor') ?> 
                                <?= isset($activeMessage['recipient_name']) ? htmlspecialchars($activeMessage['recipient_name']) : '#' . htmlspecialchars($activeMessage['recipient_id']) ?></span>
                                <span><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($activeMessage['sent_at']))) ?></span>
                            </div>
                        </div>
                        <div class="message-body">
                            <?= nl2br(htmlspecialchars($activeMessage['message'])) ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-regular fa-paper-plane"></i>
                            <p>Select a message to view details</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>