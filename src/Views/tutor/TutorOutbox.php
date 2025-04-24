<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Tutor - Outbox</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/tutor/sidebar.css">
    <link rel="stylesheet" href="/css/tutor/inbox.css">
    <link rel="stylesheet" href="/css/tutor/outbox.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <a href="/tutor-inbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'inbox') ? 'active' : '' ?>">Inbox
                </a>
                <a href="/tutor-inbox?status=archived" class="tab-link <?= (isset($activeTab) && $activeTab === 'archived') ? 'active' : '' ?>">Archived</a>
                <a href="/tutor-compose-message" class="tab-link <?= (isset($activeTab) && $activeTab === 'compose') ? 'active' : '' ?>">Compose</a>
                <a href="/tutor-outbox" class="tab-link <?= (isset($activeTab) && $activeTab === 'outbox') ? 'active' : '' ?>">Outbox</a>
            </div>
            
            <form method="POST" class="search-form" action="/tutor-outbox">
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
                            <option value="/tutor-outbox" <?= !isset($_GET['filter']) ? 'selected' : '' ?>>All</option>
                            <option value="/tutor-outbox?filter=student" <?= isset($_GET['filter']) && $_GET['filter'] === 'student' ? 'selected' : '' ?>>To Students</option>
                            <option value="/tutor-outbox?filter=admin" <?= isset($_GET['filter']) && $_GET['filter'] === 'admin' ? 'selected' : '' ?>>To Admin</option>
                        </select>
                    </div>
                    
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $message): ?>
                            <div class="message-item <?= isset($activeMessage) && $activeMessage['message_id'] == $message['message_id'] && $activeMessage['recipient_type'] == $message['recipient_type'] ? 'active' : '' ?>" 
                                 onclick="window.location.href='/tutor-outbox-message/<?= $message['message_id'] ?>/<?= $message['recipient_type'] ?>'">
                                <div class="message-subject"><?= htmlspecialchars($message['subject']) ?></div>
                                <div class="message-sender">
                                    To: <?= htmlspecialchars($message['recipient_type'] === 'student' ? 'Student: ' . htmlspecialchars($message['recipient_name'] ?? 'Unknown') : 'Admin') ?>
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
                                <span>To: <?= htmlspecialchars($activeMessage['recipient_type'] === 'student' ? 'Student: ' . htmlspecialchars($activeMessage['recipient_name'] ?? 'Unknown') : 'Admin') ?></span>
                                <span><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($activeMessage['sent_at']))) ?></span>
                            </div>
                        </div>
                        <div class="message-body">
                            <?= nl2br(htmlspecialchars($activeMessage['message'])) ?>
                        </div>
                        
                        <?php if (!empty($recipientReplies)): ?>
                            <div class="recipient-replies">
                                <h4>Replies from <?= ucfirst($activeMessage['recipient_type']) ?></h4>
                                <?php foreach ($recipientReplies as $reply): ?>
                                    <div class="reply-item recipient-reply">
                                        <div class="reply-sender">
                                            <?php if ($activeMessage['recipient_type'] === 'student'): ?>
                                                <?= htmlspecialchars($reply['student_first_name'] . ' ' . $reply['student_last_name']) ?>
                                            <?php else: ?>
                                                Admin
                                            <?php endif; ?>
                                        </div>
                                        <div class="reply-text"><?= nl2br(htmlspecialchars($reply['message'])) ?></div>
                                        <div class="reply-date"><?= htmlspecialchars(date('F d, Y \a\t h:i A', strtotime($reply['created_at']))) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
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