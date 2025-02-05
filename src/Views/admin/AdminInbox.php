<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Existing head content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/AdminInbox.css" class="css">
    <link rel="stylesheet" href="/js/admin/Admin.js" class="js">
    <script src="/js/admin/AdminInbox.js"></script>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <div class="messages-container">
            <!-- Message Filters and Search -->
            <div class="messages-header">
                <form method="GET" action="" class="search-form">
                    <div class="searchbar">
                        <input type="text" name="search" placeholder="Search messages..." 
                               id="messageSearch" 
                               value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        <button type="submit" name="search">
                        Search
                        </button>
                    </div>
                    <div class="filters">
                        <select name="filter" class="filter-select">
                            <option value="all" <?php echo ($_GET['filter'] ?? '') === 'all' ? 'selected' : ''; ?>>All Messages</option>
                            <option value="students" <?php echo ($_GET['filter'] ?? '') === 'students' ? 'selected' : ''; ?>>From Students</option>
                            <option value="teachers" <?php echo ($_GET['filter'] ?? '') === 'teachers' ? 'selected' : ''; ?>>From Teachers</option>
                            <option value="unread" <?php echo ($_GET['filter'] ?? '') === 'unread' ? 'selected' : ''; ?>>Unread</option>
                            <option value="flagged" <?php echo ($_GET['filter'] ?? '') === 'flagged' ? 'selected' : ''; ?>>Flagged</option>
                        </select>
                        <select name="sort" class="filter-select">
                            <option value="newest" <?php echo ($_GET['sort'] ?? '') === 'newest' ? 'selected' : ''; ?>>Newest First</option>
                            <option value="oldest" <?php echo ($_GET['sort'] ?? '') === 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                            <option value="priority" <?php echo ($_GET['sort'] ?? '') === 'priority' ? 'selected' : ''; ?>>Priority</option>
                        </select>
                        <button type="submit" class="filter-btn">Apply</button>
                    </div>
                </form>
            </div>

            <!-- Messages List -->
            <div class="messages-grid">
                <?php foreach ($messages as $message): ?>
                    <div class="message-card 
                        <?php 
                        echo $message['status'] . ' '; 
                        echo ($message['priority'] === 'high') ? 'high-priority' : ''; 
                        ?>">
                        <div class="message-header">
                            <div class="sender-info">
                                <span class="sender-badge <?php echo $message['sender_type']; ?>">
                                    <?php echo ucfirst($message['sender_type']); ?>
                                </span>
                                <span class="sender-name"><?php echo htmlspecialchars($message['sender_name']); ?></span>
                            </div>
                            <div class="message-time">
                                <?php echo date('M d, H:i', strtotime($message['timestamp'])); ?>
                            </div>
                        </div>
                        <div class="message-subject">
                            <h3><?php echo htmlspecialchars($message['subject']); ?></h3>
                        </div>
                        <div class="message-preview">
                            <?php echo htmlspecialchars(substr($message['message'], 0, 100)) . '...'; ?>
                        </div>
                        <div class="message-actions">
                            <button class="action-btn" onclick="viewMessage(<?php echo $message['id']; ?>)">
                                View
                            </button>
                            <button class="action-btn" onclick="flagMessage(<?php echo $message['id']; ?>)">
                                Flag
                            </button>
                            <button class="action-btn" onclick="deleteMessage(<?php echo $message['id']; ?>)">
                                Delete
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>