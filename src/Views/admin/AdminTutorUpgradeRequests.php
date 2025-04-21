<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Tutor Upgrade Requests</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin/AdminTutorRequests.css">
    <style>
        .upgrade-container {
            padding: 20px;
        }
        
        .filters-container {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .search-form .form-group {
            flex: 1;
            min-width: 200px;
        }
        
        .search-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .search-form input, .search-form select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .search-form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .search-form .reset-btn {
            background-color: #f44336;
        }
        
        .requests-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }
        
        .request-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            transition: transform 0.2s, box-shadow 0.2s;
            overflow: hidden;
        }
        
        .request-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.4);
        }
        
        .request-content {
            padding: 10px;
        }
        
        .request-profile {
            text-align: center;
            margin-bottom: 5px;
        }
        
        .request-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }
        
        .request-name {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .request-email {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        
        .request-details {
            margin-bottom: 5px;
        }
        
        .request-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .request-detail-label {
            font-weight: 500;
            color: #555;
        }
        
        .level-badges {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }
        
        .level-badge {
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
            font-size: 12px;
            font-weight: 500;
        }
        
        .current-level {
            background-color: #3498db;
        }
        
        .requested-level {
            background-color: #9b59b6;
        }
        
        .request-body {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-style: italic;
            color: #555;
        }
        
        .request-actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        
        .action-btn {
            flex: 1;
            padding: 8px;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        
        .view-btn {
            background-color: #3498db;
        }
        
        .approve-btn {
            background-color: #2ecc71;
        }
        
        .reject-btn {
            background-color: #e74c3c;
        }
        
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #666;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .pagination a {
            padding: 8px 12px;
            background-color: #f5f5f5;
            border-radius: 4px;
            color: #333;
            text-decoration: none;
        }
        
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <div class="admin-dashboard upgrade-container">
            <h2>Tutor Upgrade Requests</h2>
            
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
            
            <!--<div class="filters-container">
                <form action="/admin-tutor-upgrade-requests" method="POST" class="search-form">
                    <input type="hidden" name="search" value="1">
                    
                    <div class="form-group">
                        <label for="search_term">Search:</label>
                        <input type="text" id="search_term" name="search_term" placeholder="Name, Email, ID..." value="<?= htmlspecialchars($_POST['search_term'] ?? $_GET['search_term'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="level">Requested Level:</label>
                        <select id="level" name="level">
                            <option value="">All Levels</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?= htmlspecialchars($level['tutor_level_id']) ?>" <?= (isset($_POST['level']) || isset($_GET['level'])) && ($level['tutor_level_id'] == ($_POST['level'] ?? $_GET['level'])) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($level['tutor_level_id']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date">From Date:</label>
                        <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($_POST['start_date'] ?? $_GET['start_date'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date">To Date:</label>
                        <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($_POST['end_date'] ?? $_GET['end_date'] ?? '') ?>">
                    </div>
                    
                    <div class="form-group" style="display: flex; align-items: flex-end;">
                        <button type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                    
                    <div class="form-group" style="display: flex; align-items: flex-end;">
                        <button type="button" class="reset-btn" onclick="resetFilters()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>-->
            
            <div class="requests-grid">
                <?php if (!empty($upgradeRequests) && is_array($upgradeRequests)): ?>
                    <?php 
                    $perPage = 12;
                    $total = count($upgradeRequests);
                    $pages = ceil($total / $perPage);
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $page = max(1, min($page, $pages));
                    $offset = ($page - 1) * $perPage;
                    $paginatedRequests = array_slice($upgradeRequests, $offset, $perPage);
                    ?>
                    <?php foreach ($paginatedRequests as $request): ?>
                        <div class="request-card">
                            <div class="request-content">
                                <div class="request-profile">
                                    <img src="\images\tutor_uploads\tutor_profile_photos\<?= !empty($request['tutor_profile_photo']) ? htmlspecialchars($request['tutor_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="request-photo">
                                    <h3 class="request-name"><?= htmlspecialchars($request['tutor_first_name'] ?? '') . ' ' . htmlspecialchars($request['tutor_last_name'] ?? ''); ?></h3>
                                    <p class="request-email"><?= htmlspecialchars($request['tutor_email'] ?? ''); ?></p>
                                </div>
                                
                                <div class="request-details">
                                    <div class="request-detail">
                                        <span class="request-detail-label">Request ID:</span>
                                        <span><?= htmlspecialchars($request['request_id'] ?? ''); ?></span>
                                    </div>
                                    <div class="request-detail">
                                        <span class="request-detail-label">Tutor ID:</span>
                                        <span><?= htmlspecialchars($request['tutor_id'] ?? ''); ?></span>
                                    </div>
                                    <div class="request-detail">
                                        <span class="request-detail-label">Request Date:</span>
                                        <span><?= htmlspecialchars($request['request_date'] ?? ''); ?></span>
                                    </div>
                                    
                                    <div class="level-badges">
                                        <?php if (!empty($request['current_level_id'])): ?>
                                        <span class="level-badge current-level">
                                            Current: <?= htmlspecialchars($request['current_level_id']); ?>
                                        </span>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($request['requested_level_id'])): ?>
                                        <span class="level-badge requested-level">
                                            Requested: <?= htmlspecialchars($request['requested_level_id']); ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if (!empty($request['request_body'])): ?>
                                    <div class="request-body">
                                        "<?= htmlspecialchars($request['request_body']); ?>"
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="request-actions">
                                    <a href="/admin-tutor-upgrade-details/<?= htmlspecialchars($request['request_id']); ?>" class="action-btn view-btn">
                                        <i class="fas fa-eye"></i> Details
                                    </a>
                                    <form action="/admin-approve-upgrade/<?= htmlspecialchars($request['request_id']); ?>" method="POST" onsubmit="return confirmApprove()">
                                        <button type="submit" class="action-btn approve-btn">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="/admin-reject-upgrade/<?= htmlspecialchars($request['request_id']); ?>" method="POST" onsubmit="return confirmReject()">
                                        <button type="submit" class="action-btn reject-btn">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="fas fa-inbox fa-3x" style="color: #ddd; margin-bottom: 15px;"></i>
                        <p>No pending tutor upgrade requests found.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (($pages ?? 0) > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['level']) || isset($_GET['level']) ? '&level=' . urlencode($_POST['level'] ?? $_GET['level']) : '' ?>">«</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($pages, $page + 2);
                
                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="?page=<?= $i ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['level']) || isset($_GET['level']) ? '&level=' . urlencode($_POST['level'] ?? $_GET['level']) : '' ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                
                <?php if ($page < $pages): ?>
                    <a href="?page=<?= $page + 1 ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['level']) || isset($_GET['level']) ? '&level=' . urlencode($_POST['level'] ?? $_GET['level']) : '' ?>">»</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>  
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.search-form');
            if (form) {
                form.addEventListener('submit', function() {
                    const pageInput = document.createElement('input');
                    pageInput.type = 'hidden';
                    pageInput.name = 'page';
                    pageInput.value = '1';
                    form.appendChild(pageInput);
                });
            }
        });

        function resetFilters() {
            document.getElementById('start_date').value = '';
            document.getElementById('end_date').value = '';
            document.getElementById('level').value = '';
            document.querySelector('input[name="search_term"]').value = '';
            document.querySelector('.search-form').submit();
        }

        function confirmApprove() {
            return confirm('Are you sure you want to approve this upgrade request?');
        }

        function confirmReject() {
            return confirm('Are you sure you want to reject this upgrade request?');
        }

        document.querySelector('form')?.addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date')?.value;
            const endDate = document.getElementById('end_date')?.value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                alert('Start date must be before or equal to end date');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>