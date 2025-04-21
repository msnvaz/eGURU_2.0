<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Inbox</title>
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
            
            <form method="POST" class="search-form" action="/admin-inbox">
                <div class="searchbar">
                    <input type="text" name="search_term" placeholder="Search messages..." value="<?= htmlspecialchars($searchTerm ?? '') ?>">
                    <button type="submit" name="search">Search</button>
                </div>
            </form>
            
            <div class="inbox-container">
                <div class="inbox-sidebar">
                    <div class="status-filter">
                        <label>Filter:</label>
                        <select name="filter" onchange="window.location.href = this.value">
                            <option value="/admin-inbox" <?= !isset($_GET['filter']) ? 'selected' : '' ?>>All</option>
                            <option value="/admin-inbox?filter=unread" <?= isset($_GET['filter']) && $_GET['filter'] === 'unread' ? 'selected' : '' ?>>Unread</option>
                            <option value="/admin-inbox?filter=read" <?= isset($_GET['filter']) && $_GET['filter'] === 'read' ? 'selected' : '' ?>>Read</option>
                            <option value="/admin-inbox?filter=student" <?= isset($_GET['filter']) && $_GET['filter'] === 'student' ? 'selected' : '' ?>>From Students</option>
                            <option value="/admin-inbox?filter=tutor" <?= isset($_GET['filter']) && $_GET['filter'] === 'tutor' ? 'selected' : '' ?>>From Tutors</option>
                        </select>
                    </div>
                    
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="message-item <?= $message['status'] === 'unread' ? 'unread' : '' ?> <?= isset($activeMessage) && $activeMessage['inbox_id'] == $message['inbox_id'] ? 'active' : '' ?>"
                                 onclick="window.location.href='/admin-inbox-message/<?= $message['inbox_id'] ?>'">
                                <div class="message-subject"><?= htmlspecialchars($message['subject']) ?></div>
                                <div class="message-sender">
                                    From: <?= htmlspecialchars($message['sender_type']) === 'student' ? 'Student' : 'Tutor' ?> #<?= htmlspecialchars($message['sender_id']) ?>
                                </div>
                                <div class="message-preview"><?= htmlspecialchars(substr($message['message'], 0, 60) . (strlen($message['message']) > 60 ? '...' : '')) ?></div>
                                <div class="message-date"><?= htmlspecialchars(date('M d, Y', strtotime($message['sent_at']))) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-regular fa-envelope-open"></i>
                            <p>No messages found</p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($totalPages > 1): ?>
                        <div class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <a href="?page=<?= $i ?><?= isset($_GET['status']) ? '&status=' . $_GET['status'] : '' ?><?= isset($_GET['filter']) ? '&filter=' . $_GET['filter'] : '' ?>" 
                                   class="<?= $currentPage == $i ? 'active' : '' ?>"><?= $i ?></a>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="inbox-content">
                    <?php if (isset($activeMessage)): ?>
                        <div class="message-header">
                        <div class="message-header">
                            <h3 class="message-subject-header"><?= htmlspecialchars($activeMessage['subject']) ?></h3>
                            <div class="message-info">
                                <span>From: <?= htmlspecialchars($activeMessage['sender_type']) === 'student' ? 'Student' : 'Tutor' ?> #<?= htmlspecialchars($activeMessage['sender_id']) ?></span>
                                <span><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($activeMessage['sent_at']))) ?></span>
                            </div>
                        </div>
                        <div class="message-body">
                            <?= nl2br(htmlspecialchars($activeMessage['message'])) ?>
                        </div>
                        <div class="action-buttons">
                            <?php if ($activeMessage['status'] === 'archived'): ?>
                                <form action="/admin-inbox-unarchive/<?= $activeMessage['inbox_id'] ?>" method="post">
                                    <button type="submit" class="action-button">Unarchive</button>
                                </form>
                            <?php else: ?>
                                <form action="/admin-inbox-archive/<?= $activeMessage['inbox_id'] ?>" method="post">
                                    <button type="submit" class="action-button archive">Archive</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($replies)): ?>
                            <div class="previous-replies">
                                <h4>Previous Replies</h4>
                                <?php foreach ($replies as $reply): ?>
                                    <div class="reply-item">
                                        <div class="reply-admin">Admin: <?= htmlspecialchars($reply['admin_username']) ?></div>
                                        <div class="reply-text"><?= nl2br(htmlspecialchars($reply['reply_message'])) ?></div>
                                        <div class="reply-date"><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($reply['replied_at']))) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="reply-container">
                            <h4 class="reply-header">Reply</h4>
                            <form action="/admin-inbox-reply/<?= $activeMessage['inbox_id'] ?>" method="post" class="reply-form">
                                <textarea name="reply_message" placeholder="Type your reply here..." required></textarea>
                                <button type="submit">Send Reply</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fa-regular fa-envelope"></i>
                            <p>Select a message to view details</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>