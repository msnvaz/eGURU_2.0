<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Tutor Requests</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/AdminTutors.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .date-range-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }
        .date-range, .filter-selection {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .tutor-card.requested {
            border: 2px solid #ffc107;
        }
        .tutor-card.requested::before {
            content: "PENDING";
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #ffc107;
            color: black;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .action-buttons form {
            flex: 1;
            margin: 0 5px;
        }
        .approve-button, .reject-button, .view-proof-button {
            width: 100%;
            padding: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
        }
        .approve-button {
            background-color: #28a745;
            color: white;
        }
        .reject-button {
            background-color: #dc3545;
            color: white;
        }
        .view-proof-button {
            background-color: #17a2b8;
            color: white;
        }
        .qualification-proof {
            margin-top: 10px;
            padding: 5px;
            background-color: #f8f9fa;
            border-radius: 3px;
        }
        .notification {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        @media (max-width: 768px) {
            .tutor-card {
                width: calc(50% - 20px);
            }
            .date-range, .filter-selection {
                flex-direction: column;
                align-items: flex-start;
            }
            .action-buttons {
                flex-direction: column;
            }
            .action-buttons form {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <div class="admin-dashboard">
            <br>
            <h2>Tutor Requests</h2>
            <p>Manage tutor requests and approvals.</p>
            <br>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="notification success">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="notification error">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
            
            <div class="tutor-cards">
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
                        <div class="tutor-card requested">
                            <a href="/admin-tutor-profile/<?= htmlspecialchars($row['tutor_id'] ?? ''); ?>" class="tutor-card-link">
                                <img src="\images\tutor_uploads\tutor_profile_photos\<?= !empty($row['tutor_profile_photo']) ? htmlspecialchars($row['tutor_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="tutor-photo">
                                <div class="tutor-card-content">
                                    <p class="tutor-name"><?= htmlspecialchars($row['tutor_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($row['tutor_last_name'] ?? 'Last Name'); ?></p>
                                    <p class="tutor-email"><?= htmlspecialchars($row['tutor_email'] ?? 'Email not available'); ?></p>
                                    <p class="tutor-registration">ID: <?= htmlspecialchars($row['tutor_id'] ?? 'Not Found'); ?></p>
                                    <p class="tutor-registration">Registration Date: <?= htmlspecialchars($row['tutor_registration_date'] ?? 'Not Found'); ?></p>
                                    <?php if (!empty($row['tutor_level_id'])): ?>
                                    <p class="tutor-level">Grade Level: <?= htmlspecialchars($row['tutor_level_id'] ?? 'N/A'); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($row['tutor_qualification_proof'])): ?>
                                    <div class="qualification-proof">
                                        <p>Qualification Proof: <?= htmlspecialchars($row['tutor_qualification_proof']); ?></p>
                                        <a href="/download-qualification-proof/<?= htmlspecialchars($row['tutor_id']); ?>" class="view-proof-button">
                                            <i class="fas fa-download"></i> Download Proof
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="action-buttons">
                                <form action="/admin-approve-tutor/<?= htmlspecialchars($row['tutor_id']); ?>" method="POST" onsubmit="return confirmApprove()">
                                    <button type="submit" class="approve-button">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                                <form action="/admin-reject-tutor/<?= htmlspecialchars($row['tutor_id']); ?>" method="POST" onsubmit="return confirmReject()">
                                    <button type="submit" class="reject-button">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No pending tutor requests found.</p>
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
            form.addEventListener('submit', function() {
                const pageInput = document.createElement('input');
                pageInput.type = 'hidden';
                pageInput.name = 'page';
                pageInput.value = '1';
                form.appendChild(pageInput);
            });
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

        document.querySelector('form').addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                alert('Start date must be before or equal to end date');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>