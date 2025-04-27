<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Tutor - Inbox</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link rel="stylesheet" href="/css/tutor/inbox.css">
    <link rel="stylesheet" href="/css/tutor/outbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .notification-badge {
            display: inline-block;
            background-color: #ff5869;
            color: white;
            border-radius: 50%;
            padding: 4px 7px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            text-align: center;
            min-width: 20px;
            height: 20px;
        }

    </style>
</head>
<body>
   
<?php $page="inbox"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>
    
    <div class="main">
        <br>
        <div class="tutor-dashboard">
        
            <div class="inbox-tabs">
                <a href="/tutor-inbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'inbox') ? 'active' : '' ?>">Inbox <span class="notification-badge"><?= htmlspecialchars($unreadCount)?></span>
                </a>
                <a href="/tutor-inbox?status=archived" class="tab-link <?= (isset($activeTab) && $activeTab === 'archived') ? 'active' : '' ?>">Archived</a>
                <a href="/tutor-compose-message" class="tab-link <?= (isset($activeTab) && $activeTab === 'compose') ? 'active' : '' ?>">Compose</a>
                <a href="/tutor-outbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'outbox') ? 'active' : '' ?>">Outbox</a>
            </div>
            
            <form method="POST" class="search-form" action="/tutor-inbox">
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
                            <option value="/tutor-inbox" <?= !isset($_GET['filter']) ? 'selected' : '' ?>>All</option>
                            <option value="/tutor-inbox?filter=unread" <?= isset($_GET['filter']) && $_GET['filter'] === 'unread' ? 'selected' : '' ?>>Unread</option>
                            <option value="/tutor-inbox?filter=read" <?= isset($_GET['filter']) && $_GET['filter'] === 'read' ? 'selected' : '' ?>>Read</option>
                            <option value="/tutor-inbox?filter=student" <?= isset($_GET['filter']) && $_GET['filter'] === 'student' ? 'selected' : '' ?>>From Students</option>
                            <option value="/tutor-inbox?filter=admin" <?= isset($_GET['filter']) && $_GET['filter'] === 'admin' ? 'selected' : '' ?>>From Admin</option>
                        </select>
                    </div>
                    
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="message-item <?= $message['status'] === 'unread' ? 'unread' : '' ?> <?= isset($activeMessage) && $activeMessage['inbox_id'] == $message['inbox_id'] ? 'active' : '' ?>"
                                 onclick="window.location.href='/tutor-inbox-message/<?= $message['inbox_id'] ?>'">
                                <div class="message-subject"><?= htmlspecialchars($message['subject']) ?></div>
                                <div class="message-sender">
                                    From: <?= htmlspecialchars($message['sender_type']) === 'student' ? 'Student: ' . htmlspecialchars($message['student_first_name'].' '.$message['student_last_name']) : 'Admin' ?>
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
                                <span>From: <?= htmlspecialchars($activeMessage['sender_type']) === 'student' ? 'Student: ' . htmlspecialchars($activeMessage['student_first_name'].' '.$message['student_last_name']) : 'Admin' ?></span>
                                <span><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($activeMessage['sent_at']))) ?></span>
                            </div>
                        </div>
                        <div class="message-body">
                            <?= nl2br(htmlspecialchars($activeMessage['message'])) ?>
                        </div>
                        <div class="action-buttons">
                            <?php if ($activeMessage['status'] === 'archived'): ?>
                                <form action="/tutor-inbox-unarchive/<?= $activeMessage['inbox_id'] ?>" method="post">
                                    <button type="submit" class="action-button">Unarchive</button>
                                </form>
                            <?php else: ?>
                                <form action="/tutor-inbox-archive/<?= $activeMessage['inbox_id'] ?>" method="post">
                                    <button type="submit" class="action-button archive">Archive</button>
                                </form>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($replies)): ?>
                            <div class="previous-replies">
                                <h4>Previous Replies</h4>
                                <?php foreach ($replies as $reply): ?>
                                    <div class="reply-item">
                                        <div class="reply-tutor">Tutor: <?= htmlspecialchars($reply['tutor_first_name'].' '.$reply['tutor_last_name']) ?></div>
                                        <div class="reply-text"><?= nl2br(htmlspecialchars($reply['message'])) ?></div>
                                        <div class="reply-date"><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($reply['created_at']))) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="reply-container">
                            <h4 class="reply-header">Reply</h4>
                            <form action="/tutor-inbox-reply/<?= $activeMessage['inbox_id'] ?>" method="post" class="reply-form">
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