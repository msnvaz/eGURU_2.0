<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Student - Inbox</title>
    <link rel="icon" type="image/png" href="/images/eGURU_3.png">
    <link rel="stylesheet" href="/css/student/sidebar.css">
    <link rel="stylesheet" href="/css/student/nav.css">
    <link rel="stylesheet" href="/css/student/header.css">
    <link rel="stylesheet" href="/css/student/StudentInbox.css">
    <link rel="stylesheet" href="/css/student/StudentComposeMessage.css">
    <link rel="stylesheet" href="/css/student/StudentOutbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
   
<?php $page="inbox"; ?>

<?php include '../src/Views/student/header.php'; ?>
<?php include 'sidebar.php'; ?>

    <div class="main">
        <br><br>
        <div class="student-dashboard">
        
            <div class="inbox-tabs">
                <a href="/student-inbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'inbox') ? 'active' : '' ?>">Inbox<span class="notification-badge"><?= htmlspecialchars($unreadCount) ?></span>
                </a>
                <a href="/student-inbox?status=archived" class="tab-link <?= (isset($activeTab) && $activeTab === 'archived') ? 'active' : '' ?>">Archived</a>
                <a href="/student-compose-message" class="tab-link <?= (isset($activeTab) && $activeTab === 'compose') ? 'active' : '' ?>">Compose</a>
                <a href="/student-outbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'outbox') ? 'active' : '' ?>">Outbox</a>
            </div>
            
            <form method="POST" class="search-form" action="/student-inbox">
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
                            <option value="/student-inbox" <?= !isset($_GET['filter']) ? 'selected' : '' ?>>All</option>
                            <option value="/student-inbox?filter=unread" <?= isset($_GET['filter']) && $_GET['filter'] === 'unread' ? 'selected' : '' ?>>Unread</option>
                            <option value="/student-inbox?filter=read" <?= isset($_GET['filter']) && $_GET['filter'] === 'read' ? 'selected' : '' ?>>Read</option>
                            <option value="/student-inbox?filter=tutor" <?= isset($_GET['filter']) && $_GET['filter'] === 'tutor' ? 'selected' : '' ?>>From Tutors</option>
                            <option value="/student-inbox?filter=admin" <?= isset($_GET['filter']) && $_GET['filter'] === 'admin' ? 'selected' : '' ?>>From Admin</option>
                        </select>
                    </div>
                    
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="message-item <?= $message['status'] === 'unread' ? 'unread' : '' ?> <?= isset($activeMessage) && $activeMessage['inbox_id'] == $message['inbox_id'] ? 'active' : '' ?>"
                                 onclick="window.location.href='/student-inbox-message/<?= $message['inbox_id'] ?>'">
                                <div class="message-subject"><?= htmlspecialchars($message['subject']) ?></div>
                                <div class="message-sender">
                                    From: <?= htmlspecialchars($message['sender_type']) === 'tutor' ? 'Tutor: ' . htmlspecialchars($message['tutor_first_name'].' '.$message['tutor_last_name']) : 'Admin' ?>
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
                            <h3 class="message-subject-header"><?= htmlspecialchars($activeMessage['subject']) ?></h3>
                            <div class="message-info">
                                <span>From: <?= htmlspecialchars($activeMessage['sender_type']) === 'tutor' ? 'Tutor: ' . htmlspecialchars($activeMessage['tutor_first_name'].' '.$activeMessage['tutor_last_name']) : 'Admin' ?></span>
                                <span><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($activeMessage['sent_at']))) ?></span>
                            </div>
                        </div>
                        <div class="message-body">
                            <?= nl2br(htmlspecialchars($activeMessage['message'])) ?>
                        </div>
                        <div class="action-buttons">
                            <?php if ($activeMessage['status'] === 'archived'): ?>
                                <form action="/student-inbox-unarchive/<?= $activeMessage['inbox_id'] ?>" method="post">
                                    <button type="submit" class="action-button">Unarchive</button>
                                </form>
                            <?php else: ?>
                                <form action="/student-inbox-archive/<?= $activeMessage['inbox_id'] ?>" method="post">
                                    <button type="submit" class="action-button archive">Archive</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($replies)): ?>
                            <div class="previous-replies">
                                <h4>Previous Replies</h4>
                                <?php foreach ($replies as $reply): ?>
                                    <div class="reply-item">
                                        <div class="reply-sender">
                                            <?php if ($reply['sender_type'] === 'student'): ?>
                                                You
                                            <?php else: ?>
                                                <?= htmlspecialchars($reply['sender_type'] === 'tutor' ? 'Tutor: ' . $reply['tutor_first_name'] . ' ' . $reply['tutor_last_name'] : 'Admin') ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="reply-text"><?= nl2br(htmlspecialchars($reply['message'])) ?></div>
                                        <div class="reply-date"><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($reply['created_at']))) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="reply-container">
                            <h4 class="reply-header">Reply</h4>
                            <form action="/student-inbox-reply/<?= $activeMessage['inbox_id'] ?>" method="post" class="reply-form">
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