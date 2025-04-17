<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Student Management</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
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
        @media (max-width: 768px) {
            .student-card {
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
                <a href="/admin-students" class="tab-link <?= !isset($deletedStudents) ? 'active' : '' ?>">Active Students</a>
                <a href="/admin-deleted-students" class="tab-link <?= isset($deletedStudents) ? 'active' : '' ?>">Deleted Students</a>
            </div>
            <br>
            <form method="POST" class="search-form" style="font-size: 12px;">
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
                        <label for="grade">Grade:</label>
                        <select name="grade" id="grade">
                            <option value="">All Grades</option>
                            <?php foreach ($grades as $grade) : ?>
                                <option value="<?= htmlspecialchars($grade['student_grade']) ?>" 
                                    <?= (isset($_POST['grade']) && $_POST['grade'] == $grade['student_grade']) || 
                                        (isset($_GET['grade']) && $_GET['grade'] == $grade['student_grade']) ? 'selected' : '' ?>>
                                    Grade <?= htmlspecialchars($grade['student_grade']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        
                        <?php if (!isset($deletedStudents)) : ?>
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

            <div class="student-cards">
                <?php if (isset($deletedStudents)): ?>
                    <?php if (!empty($deletedStudents) && is_array($deletedStudents)): ?>
                        <?php 
                        // Pagination for deleted students
                        $perPage = 12;
                        $total = count($deletedStudents);
                        $pages = ceil($total / $perPage);
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $page = max(1, min($page, $pages)); // Ensure page is within valid range
                        $offset = ($page - 1) * $perPage;
                        $paginatedStudents = array_slice($deletedStudents, $offset, $perPage);
                        ?>
                        <?php foreach ($paginatedStudents as $row): ?>
                            <div class="student-card deleted">
                                <a href="/admin-student-profile/<?= isset($row['student_id']) ? htmlspecialchars($row['student_id']) : ''; ?>" class="student-card-link">
                                    <img src="/uploads/Student_Profiles/<?= !empty($row['student_profile_photo']) ? htmlspecialchars($row['student_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="student-photo">
                                    <div class="student-card-content">
                                        <p class="student-name"><?= htmlspecialchars($row['student_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($row['student_last_name'] ?? 'Last Name'); ?></p>
                                        <p class="student-email"><?= htmlspecialchars($row['student_email'] ?? 'Email not available'); ?></p>
                                        <p class="student-registration">ID: <?= htmlspecialchars($row['student_id'] ?? 'Not Found'); ?></p>
                                        <?php if (!empty($row['student_grade'])): ?>
                                        <p class="student-points">Grade: <?= htmlspecialchars($row['student_grade'] ?? 'N/A'); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No deleted students found.</p>
                    <?php endif; ?>
                <?php elseif (!empty($students) && is_array($students)): ?>
                    <?php 
                    // Pagination for active students
                    $perPage = 12;
                    $total = count($students);
                    $pages = ceil($total / $perPage);
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $page = max(1, min($page, $pages)); // Ensure page is within valid range
                    $offset = ($page - 1) * $perPage;
                    $paginatedStudents = array_slice($students, $offset, $perPage);
                    ?>
                    <?php foreach ($paginatedStudents as $row): ?>
                        <div class="student-card <?= $row['student_log'] === 'online' ? 'online' : '' ?>">
                            <a href="/admin-student-profile/<?= htmlspecialchars($row['student_id'] ?? ''); ?>" class="student-card-link">
                                <img src="/uploads/Student_Profiles/<?= !empty($row['student_profile_photo']) ? htmlspecialchars($row['student_profile_photo']) : 'default.jpg'; ?>" alt="Profile Photo" class="student-photo">
                                <div class="student-card-content">
                                    <p class="student-name"><?= htmlspecialchars($row['student_first_name'] ?? 'First Name') . ' ' . htmlspecialchars($row['student_last_name'] ?? 'Last Name'); ?></p>
                                    <p class="student-email"><?= htmlspecialchars($row['student_email'] ?? 'Email not available'); ?></p>
                                    <p class="student-registration">ID: <?= htmlspecialchars($row['student_id'] ?? 'Not Found'); ?></p>
                                    <?php if (!empty($row['student_grade'])): ?>
                                    <p class="student-points">Grade: <?= htmlspecialchars($row['student_grade'] ?? 'N/A'); ?></p>
                                    <?php endif; ?>
                                    <p class="student-status">Status: <?= htmlspecialchars($row['student_log'] ?? 'offline'); ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No students found.</p>
                <?php endif; ?>
            </div>

            <?php if (($pages ?? 0) > 1): ?>
            <div class="pagination">
                <?php
                // Previous button
                if ($page > 1): ?>
                    <a href="?page=<?= $page - 1 ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['grade']) || isset($_GET['grade']) ? '&grade=' . urlencode($_POST['grade'] ?? $_GET['grade']) : '' ?><?= isset($_POST['online_status']) || isset($_GET['online_status']) ? '&online_status=' . urlencode($_POST['online_status'] ?? $_GET['online_status']) : '' ?>">«</a>
                <?php endif; ?>
                
                <?php
                // Page numbers
                $startPage = max(1, $page - 2);
                $endPage = min($pages, $page + 2);
                
                for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="?page=<?= $i ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['grade']) || isset($_GET['grade']) ? '&grade=' . urlencode($_POST['grade'] ?? $_GET['grade']) : '' ?><?= isset($_POST['online_status']) || isset($_GET['online_status']) ? '&online_status=' . urlencode($_POST['online_status'] ?? $_GET['online_status']) : '' ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
                
                <?php
                // Next button
                if ($page < $pages): ?>
                    <a href="?page=<?= $page + 1 ?><?= isset($_POST['search']) || isset($_GET['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) || isset($_GET['search_term']) ? '&search_term=' . urlencode($_POST['search_term'] ?? $_GET['search_term']) : '' ?><?= isset($_POST['start_date']) || isset($_GET['start_date']) ? '&start_date=' . urlencode($_POST['start_date'] ?? $_GET['start_date']) : '' ?><?= isset($_POST['end_date']) || isset($_GET['end_date']) ? '&end_date=' . urlencode($_POST['end_date'] ?? $_GET['end_date']) : '' ?><?= isset($_POST['grade']) || isset($_GET['grade']) ? '&grade=' . urlencode($_POST['grade'] ?? $_GET['grade']) : '' ?><?= isset($_POST['online_status']) || isset($_GET['online_status']) ? '&online_status=' . urlencode($_POST['online_status'] ?? $_GET['online_status']) : '' ?>">»</a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>  
    </div>

    <script>
        // Preserve search parameters when changing pages
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.search-form');
            form.addEventListener('submit', function() {
                // Reset page to 1 when submitting a new search
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
            <?php if (!isset($deletedStudents)) : ?>
            document.getElementById('online_status').value = '';
            <?php endif; ?>
            document.querySelector('input[name="search_term"]').value = '';
            document.querySelector('.search-form').submit();
        }

        // Optional: Add form validation
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