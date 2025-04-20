<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Tutor Requests</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin/AdminTutorRequests.css">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <div class="admin-dashboard requests-container">
            <h2>Tutor Requests</h2>
            
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
                <?php if (!empty($pendingTutors) && is_array($pendingTutors)): ?>
                    <?php 
                    $perPage = 12;
                    $total = count($pendingTutors);
                    $pages = ceil($total / $perPage);
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $page = max(1, min($page, $pages));
                    $offset = ($page - 1) * $perPage;
                    $paginatedTutors = array_slice($pendingTutors, $offset, $perPage);
                    ?>
                    <?php foreach ($paginatedTutors as $row): ?>
                        <a href="/admin-tutor-profile/<?= htmlspecialchars($row['tutor_id'] ?? ''); ?>" class="tutor-card-link">
                        <div class="request-card">
                            <div class="request-content">
                                <div class="request-profile">
                                    <img src="\images\tutor_uploads\tutor_profile_photos\<?= !empty($row['tutor_profile_photo']) ? htmlspecialchars($row['tutor_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="request-photo">
                                    <h3 class="request-name"><?= htmlspecialchars($row['tutor_first_name'] ?? '') . ' ' . htmlspecialchars($row['tutor_last_name'] ?? ''); ?></h3>
                                    <p class="request-email"><?= htmlspecialchars($row['tutor_email'] ?? ''); ?></p>
                                </div>
                                
                                <div class="request-details">
                                    <div class="request-detail">
                                        <span class="request-detail-label">Tutor ID:</span>
                                        <span><?= htmlspecialchars($row['tutor_id'] ?? ''); ?></span>
                                    </div>
                                    <div class="request-detail">
                                        <span class="request-detail-label">Registered:</span>
                                        <span><?= htmlspecialchars($row['tutor_registration_date'] ?? ''); ?></span>
                                    </div>
                                    <?php if (!empty($row['tutor_level_id'])): ?>
                                    <div class="request-detail">
                                        <span class="request-detail-label">Grade Level:</span>
                                        <span><?= htmlspecialchars($row['tutor_level_id'] ?? ''); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($row['tutor_qualification_proof'])): ?>
                                    <div class="proof-section">
                                        <div class="request-detail">
                                            <span class="request-detail-label">Qualification:</span>
                                            <span><?= htmlspecialchars($row['tutor_qualification_proof']); ?></span>
                                        </div>
                                        <a href="/download-qualification-proof/<?= htmlspecialchars($row['tutor_id']); ?>" class="proof-link">
                                            <i class="fas fa-download"></i> Download Proof
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="request-actions">
                                    <form action="/admin-approve-tutor/<?= htmlspecialchars($row['tutor_id']); ?>" method="POST" onsubmit="return confirmApprove()">
                                        <button type="submit" class="action-btn approve-btn">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="/admin-reject-tutor/<?= htmlspecialchars($row['tutor_id']); ?>" method="POST" onsubmit="return confirmReject()">
                                        <button type="submit" class="action-btn reject-btn">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <p>No pending tutor requests found.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (($pages ?? 0) > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['grade']) || isset($_GET['grade']) ? '&grade=' . urlencode($_POST['grade'] ?? $_GET['grade']) : '' ?>">«</a>
                <?php endif; ?>
                
                <?php
                $startPage = max(1, $page - 2);
                $endPage = min($pages, $page + 2);
                
                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="?page=<?= $i ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['grade']) || isset($_GET['grade']) ? '&grade=' . urlencode($_POST['grade'] ?? $_GET['grade']) : '' ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                
                <?php if ($page < $pages): ?>
                    <a href="?page=<?= $page + 1 ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['grade']) || isset($_GET['grade']) ? '&grade=' . urlencode($_POST['grade'] ?? $_GET['grade']) : '' ?>">»</a>
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
            document.getElementById('grade').value = '';
            document.querySelector('input[name="search_term"]').value = '';
            document.querySelector('.search-form').submit();
        }

        function confirmApprove() {
            return confirm('Are you sure you want to approve this tutor?');
        }

        function confirmReject() {
            return confirm('Are you sure you want to reject this tutor?');
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