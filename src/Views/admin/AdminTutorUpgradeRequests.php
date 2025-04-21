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
    <link rel="stylesheet" href="/css/admin/AdminTutorUpgradeRequests.css">
    <style>
        
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
                                    <div class="request-detail" style="font-size: 16px;font-weight: 600;justify-content: center;">
                                        <span class="request-detail-label"style="font-size: 16px;font-weight: 600 !important;">Request ID : </span>
                                        <span><?= htmlspecialchars($request['request_id'] ?? ''); ?></span>
                                    </div>
                                <div class="level-badges">
                                    <?php if (!empty($request['current_level_id'])): ?>
                                        <span class="level-badge current-level">
                                            Current: <?= htmlspecialchars($request['current_level_id']); ?>
                                        </span>
                                        <span><i class="fa-solid fa-arrow-right"></i></span>
                                    <?php endif; ?>
                                    
                                    <?php if (array_key_exists('requested_level_id', $request)): ?>
                                        <span class="level-badge requested-level" >
                                            Requested: <?= ($request['requested_level_id'] !== null) ? htmlspecialchars($request['requested_level_id']) : 'Not Specified'; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>                         
                                </div>
                                <div class="request-details">
                                    <div class="request-detail">
                                        <span class="request-detail-label">Tutor Name:</span>
                                        <span><?= htmlspecialchars($request['tutor_first_name'] ?? '') . ' ' . htmlspecialchars($request['tutor_last_name'] ?? ''); ?></span>
                                    </div>
                                    <div class="request-detail">
                                        <span class="request-detail-label">Tutor ID:</span>
                                        <span><?= htmlspecialchars($request['tutor_id'] ?? ''); ?></span>
                                    </div>
                                    <div class="request-detail">
                                        <span class="request-detail-label">Request Date:</span>
                                        <span><?= htmlspecialchars($request['request_date'] ?? ''); ?></span>
                                    </div>                            
                                    <?php if (!empty($request['request_body'])): ?>
                                        <div class="request-body">
                                        "<?= htmlspecialchars($request['request_body'] !== null ? $request['request_body'] : 'No message'); ?>"
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