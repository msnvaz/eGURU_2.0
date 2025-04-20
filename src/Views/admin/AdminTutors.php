<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Tutor Management</title>
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
        .tutor-card.blocked {
            border: 2px solid #d9534f;
        }
        .tutor-card.blocked::before {
            content: "BLOCKED";
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #d9534f;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        @media (max-width: 768px) {
            .tutor-card {
                width: calc(50% - 20px);
            }
            .date-range, .filter-selection {
                flex-direction: column;
                align-items: flex-start;
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
            <div class="profile-tabs">
                <a href="/admin-tutors" class="tab-link <?= !isset($deletedTutors) && !isset($blockedTutors) ? 'active' : '' ?>">Active Tutors</a>
                <a href="/admin-blocked-tutors" class="tab-link <?= isset($blockedTutors) ? 'active' : '' ?>">Blocked Tutors</a>
                <a href="/admin-deleted-tutors" class="tab-link <?= isset($deletedTutors) ? 'active' : '' ?>">Deleted Tutors</a>
            </div>
            <br>
            <form method="POST" action="<?= isset($blockedTutors) ? '/admin-blocked-tutors' : (isset($deletedTutors) ? '/admin-deleted-tutors' : '/admin-tutors') ?>" class="search-form" style="font-size: 12px;">
                <div class="date-range-container">
                    <div class="date-range">
                        <label for="start_date">Registration Start Date:</label>
                        <input type="date" name="start_date" id="start_date" 
                            value="<?= isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : (isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '') ?>">
                        <label for="end_date">Registration End Date:</label>
                        <input type="date" name="end_date" id="end_date" 
                            value="<?= isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : (isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '') ?>">
                    </div>
                    
                    <div class="filter-selection">
                        <label for="grade">Grade Level:</label>
                        <select name="grade" id="grade">
                            <option value="">All Grades</option>
                            <?php foreach ($grades as $grade) : ?>
                                <option value="<?= htmlspecialchars($grade['tutor_level_id']) ?>" 
                                    <?= (isset($_POST['grade']) && $_POST['grade'] == $grade['tutor_level_id']) || 
                                        (isset($_GET['grade']) && $_GET['grade'] == $grade['tutor_level_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($grade['tutor_level_id']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        
                        <?php if (!isset($deletedTutors) && !isset($blockedTutors)) : ?>
                        <label for="online_status">Online Status:</label>
                        <select name="online_status" id="online_status">
                            <option value="">All</option>
                            <option value="online" <?= (isset($_POST['online_status']) && $_POST['online_status'] == 'online') || 
                                (isset($_GET['online_status']) && $_GET['online_status'] == 'online') ? 'selected' : '' ?>>Online</option>
                            <option value="offline" <?= (isset($_POST['online_status']) && $_POST['online_status'] == 'offline') || 
                                (isset($_GET['online_status']) && $_GET['online_status'] == 'offline') ? 'selected' : '' ?>>Offline</option>
                        </select>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="searchbar"> 
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search_term" placeholder="Search by ID, Name or Email" 
                           value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : (isset($_GET['search_term']) ? htmlspecialchars($_GET['search_term']) : '') ?>">
                    <button type="submit" name="search" value="1">Search</button>
                    <button type="button" onclick="resetFilters()" class="reset-btn">Reset</button>
                </div>
            </form>

            <div class="tutor-cards">
                <?php if (isset($blockedTutors)): ?>
                    <?php if (!empty($blockedTutors) && is_array($blockedTutors)): ?>
                        <?php 
                        $perPage = 12;
                        $total = count($blockedTutors);
                        $pages = ceil($total / $perPage);
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $page = max(1, min($page, $pages));
                        $offset = ($page - 1) * $perPage;
                        $paginatedTutors = array_slice($blockedTutors, $offset, $perPage);
                        ?>
                        <?php foreach ($paginatedTutors as $row): ?>
                            <div class="tutor-card blocked">
                                <a href="/admin-tutor-profile/<?= isset($row['tutor_id']) ? htmlspecialchars($row['tutor_id']) : ''; ?>" class="tutor-card-link">
                                    <img src="\images\tutor_uploads\tutor_profile_photos\<?= !empty($row['tutor_profile_photo']) ? htmlspecialchars($row['tutor_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="tutor-photo">
                                    <div class="tutor-card-content">
                                        <p class="tutor-name"><?= htmlspecialchars($row['tutor_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($row['tutor_last_name'] ?? 'Last Name'); ?></p>
                                        <p class="tutor-email"><?= htmlspecialchars($row['tutor_email'] ?? 'Email not available'); ?></p>
                                        <p class="tutor-registration">ID: <?= htmlspecialchars($row['tutor_id'] ?? 'Not Found'); ?></p>
                                        <?php if (!empty($row['tutor_level_id'])): ?>
                                        <p class="tutor-level">Grade Level: <?= htmlspecialchars($row['tutor_level_id'] ?? 'N/A'); ?></p>
                                        <?php endif; ?>
                                        <p class="tutor-status">Status: Blocked</p>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No blocked tutors found.</p>
                    <?php endif; ?>
                <?php elseif (isset($deletedTutors)): ?>
                    <?php if (!empty($deletedTutors) && is_array($deletedTutors)): ?>
                        <?php 
                        $perPage = 12;
                        $total = count($deletedTutors);
                        $pages = ceil($total / $perPage);
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $page = max(1, min($page, $pages));
                        $offset = ($page - 1) * $perPage;
                        $paginatedTutors = array_slice($deletedTutors, $offset, $perPage);
                        ?>
                        <?php foreach ($paginatedTutors as $row): ?>
                            <div class="tutor-card deleted">
                                <a href="/admin-tutor-profile/<?= isset($row['tutor_id']) ? htmlspecialchars($row['tutor_id']) : ''; ?>" class="tutor-card-link">
                                    <img src="\images\tutor_uploads\tutor_profile_photos\<?= !empty($row['tutor_profile_photo']) ? htmlspecialchars($row['tutor_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="tutor-photo">
                                    <div class="tutor-card-content">
                                        <p class="tutor-name"><?= htmlspecialchars($row['tutor_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($row['tutor_last_name'] ?? 'Last Name'); ?></p>
                                        <p class="tutor-email"><?= htmlspecialchars($row['tutor_email'] ?? 'Email not available'); ?></p>
                                        <p class="tutor-registration">ID: <?= htmlspecialchars($row['tutor_id'] ?? 'Not Found'); ?></p>
                                        <?php if (!empty($row['tutor_level_id'])): ?>
                                        <p class="tutor-level">Grade Level: <?= htmlspecialchars($row['tutor_level_id'] ?? 'N/A'); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No deleted tutors found.</p>
                    <?php endif; ?>
                <?php elseif (!empty($tutors) && is_array($tutors)): ?>
                    <?php 
                    $perPage = 12;
                    $total = count($tutors);
                    $pages = ceil($total / $perPage);
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $page = max(1, min($page, $pages));
                    $offset = ($page - 1) * $perPage;
                    $paginatedTutors = array_slice($tutors, $offset, $perPage);
                    ?>
                    <?php foreach ($paginatedTutors as $row): ?>
                        <div class="tutor-card <?= $row['tutor_log'] === 'online' ? 'online' : '' ?>">
                            <a href="/admin-tutor-profile/<?= htmlspecialchars($row['tutor_id'] ?? ''); ?>" class="tutor-card-link">
                                <img src="\images\tutor_uploads\tutor_profile_photos\<?= !empty($row['tutor_profile_photo']) ? htmlspecialchars($row['tutor_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="tutor-photo">
                                <div class="tutor-card-content">
                                    <p class="tutor-name"><?= htmlspecialchars($row['tutor_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($row['tutor_last_name'] ?? 'Last Name'); ?></p>
                                    <p class="tutor-email"><?= htmlspecialchars($row['tutor_email'] ?? 'Email not available'); ?></p>
                                    <p class="tutor-registration">ID: <?= htmlspecialchars($row['tutor_id'] ?? 'Not Found'); ?></p>
                                    <?php if (!empty($row['tutor_level_id'])): ?>
                                    <p class="tutor-level">Grade Level: <?= htmlspecialchars($row['tutor_level_id'] ?? 'N/A'); ?></p>
                                    <?php endif; ?>
                                    <p class="tutor-status">Status: <?= htmlspecialchars($row['tutor_log'] ?? 'offline'); ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tutors found.</p>
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
            <?php if (!isset($deletedTutors) && !isset($blockedTutors)) : ?>
            document.getElementById('online_status').value = '';
            <?php endif; ?>
            document.querySelector('input[name="search_term"]').value = '';
            document.querySelector('.search-form').submit();
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