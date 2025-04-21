<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Sessions</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .details-row {
            display: none;
        }
        .expandable-row.expanded .expand-icon {
            transform: rotate(90deg);
        }
        .expand-icon {
            display: inline-block;
            transition: transform 0.2s;
        }
        a{
            font-weight: bold;
            color: #000;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
    </style>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <br>
        <form method="POST" class="search-form" style="font-size: 12px;">
            <div class="date-range-container">
                <div class="date-range">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" 
                        value="<?= isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : '' ?>">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" 
                        value="<?= isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : '' ?>">
                </div>
                
                <div class="tutor-student-selection">
                    <label for="tutor_id">Select Tutor:</label>
                    <select name="tutor_id" id="tutor_id">
                        <option value="">All Tutors</option>
                        <?php foreach ($tutors as $tutor) : ?>
                            <option value="<?= htmlspecialchars($tutor['tutor_id']) ?>"
                                <?= (isset($_POST['tutor_id']) && $_POST['tutor_id'] == $tutor['tutor_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tutor['tutor_full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label for="student_id">Select Student:</label>
                    <select name="student_id" id="student_id">
                        <option value="">All Students</option>
                        <?php foreach ($students as $student) : ?>
                            <option value="<?= htmlspecialchars($student['student_id']) ?>"
                                <?= (isset($_POST['student_id']) && $_POST['student_id'] == $student['student_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($student['student_full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <label for="status">Session Status:</label>
                    <select name="status" id="status">
                        <option value="">All Statuses</option>
                        <option value="requested" <?= (isset($_POST['status']) && $_POST['status'] == 'requested') ? 'selected' : '' ?>>Requested</option>
                        <option value="scheduled" <?= (isset($_POST['status']) && $_POST['status'] == 'scheduled') ? 'selected' : '' ?>>Scheduled</option>
                        <option value="completed" <?= (isset($_POST['status']) && $_POST['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= (isset($_POST['status']) && $_POST['status'] == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="searchbar"> 
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search_term" placeholder="Search by Student/Tutor Name or Email" 
                       value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : '' ?>" >
                <button type="submit" name="search" value="1">Search</button>
                <button type="submit" name="download_pdf" value="1">PDF</button>
                <button type="button" onclick="resetFilters()" class="reset-btn">Reset</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th colspan="6" style="text-align: center;border-radius: 20px 20px 0 0;font-size:14px;margin:0;">Sessions</th>
                </tr>
                <tr>
                    <th>Session ID</th>
                    <th>Student</th>
                    <th>Tutor</th>
                    <th>Scheduled Date</th>
                    <th>Schedule Time</th>
                    <th>Session Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sessions)) : ?>
                    <?php
                    // Pagination setup
                    $perPage = 20; // 20 records per page
                    $total = count($sessions);
                    $pages = ceil($total / $perPage);
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $page = max(1, min($page, $pages)); // Ensure page is within valid range
                    $offset = ($page - 1) * $perPage;
                    $paginatedSessions = array_slice($sessions, $offset, $perPage);
                    ?>
                    
                    <?php foreach ($paginatedSessions as $session) : ?>
                        <tr class="expandable-row">
                            <td>
                                <span class="expand-icon">►</span>
                                <?= htmlspecialchars($session['session_id']) ?>
                            </td>
                            <td>
                                <a href="/admin-student-profile/<?= isset($session['student_id']) ? htmlspecialchars($session['student_id']) : ''; ?>">
                                (<?= htmlspecialchars($session['student_id']) ?>)
                                <?= htmlspecialchars($session['student_first_name'] . ' ' . $session['student_last_name']) ?>
                                </a>
                            </td>
                            <td>   
                                <a href="/admin-tutor-profile/<?= isset($session['tutor_id']) ? htmlspecialchars($session['tutor_id']) : ''; ?>">
                                (<?= htmlspecialchars($session['tutor_id']) ?>)
                                <?= htmlspecialchars($session['tutor_first_name'] . ' ' . $session['tutor_last_name']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($session['scheduled_date']) ?></td>
                            <td><?= htmlspecialchars($session['schedule_time']) ?></td>
                            <td><?= htmlspecialchars($session['session_status']) ?></td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="6">
                                <div class="details-content">
                                    <div class="details-grid">
                                        <div class="details-grid-item" style="width: 80%; float: left;">
                                            <h4>Session Information</h4>
                                            <p><strong>Session ID:</strong> <?= htmlspecialchars($session['session_id']) ?></p>
                                            <p><strong>Scheduled Date:</strong> <?= htmlspecialchars($session['scheduled_date']) ?></p>
                                            <p><strong>Schedule Time:</strong> <?= htmlspecialchars($session['schedule_time']) ?></p>
                                            <p><strong>Session Status:</strong> <?= htmlspecialchars($session['session_status']) ?></p>
                                            <p><strong>Subject:</strong> <?= htmlspecialchars($session['subject_name']) ?></p>
                                            <p><strong>Payment Status:</strong> <?= htmlspecialchars($session['payment_status']) ?></p>
                                            <p><strong>Feedback:</strong> <?= htmlspecialchars($session['student_feedback'] ?? 'No feedback') ?></p>
                                        </div>
                                        <div class="details-grid-item" style="width: 80%; float: right; margin-top:0px;">
                                            <h4>Tutor/Student Information</h4>
                                            <p><strong>Tutor ID:</strong> <?= htmlspecialchars($session['tutor_id']) ?></p>
                                            <p><strong>Tutor:</strong> <?= htmlspecialchars($session['tutor_first_name'] . ' ' . $session['tutor_last_name']) ?> (<?= htmlspecialchars($session['tutor_email']) ?>)</p>
                                            <p><strong>Student ID:</strong> <?= htmlspecialchars($session['student_id']) ?></p>
                                            <p><strong>Student:</strong> <?= htmlspecialchars($session['student_first_name'] . ' ' . $session['student_last_name']) ?> (<?= htmlspecialchars($session['student_email']) ?>)</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="6">No sessions found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if (!empty($sessions) && $pages > 1): ?>
        <div class="pagination">
            <?php
            // Previous button
            if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?><?= isset($_POST['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) ? '&search_term=' . urlencode($_POST['search_term']) : '' ?><?= isset($_POST['start_date']) ? '&start_date=' . urlencode($_POST['start_date']) : '' ?><?= isset($_POST['end_date']) ? '&end_date=' . urlencode($_POST['end_date']) : '' ?><?= isset($_POST['tutor_id']) ? '&tutor_id=' . urlencode($_POST['tutor_id']) : '' ?><?= isset($_POST['student_id']) ? '&student_id=' . urlencode($_POST['student_id']) : '' ?><?= isset($_POST['status']) ? '&status=' . urlencode($_POST['status']) : '' ?>">«</a>
            <?php endif; ?>
            
            <?php
            // Page numbers
            $startPage = max(1, $page - 2);
            $endPage = min($pages, $page + 2);
            
            for ($i = $startPage; $i <= $endPage; $i++): ?>
                <a href="?page=<?= $i ?><?= isset($_POST['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) ? '&search_term=' . urlencode($_POST['search_term']) : '' ?><?= isset($_POST['start_date']) ? '&start_date=' . urlencode($_POST['start_date']) : '' ?><?= isset($_POST['end_date']) ? '&end_date=' . urlencode($_POST['end_date']) : '' ?><?= isset($_POST['tutor_id']) ? '&tutor_id=' . urlencode($_POST['tutor_id']) : '' ?><?= isset($_POST['student_id']) ? '&student_id=' . urlencode($_POST['student_id']) : '' ?><?= isset($_POST['status']) ? '&status=' . urlencode($_POST['status']) : '' ?>" class="<?= $page == $i ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
            
            <?php
            // Next button
            if ($page < $pages): ?>
                <a href="?page=<?= $page + 1 ?><?= isset($_POST['search']) ? '&search=1' : '' ?><?= isset($_POST['search_term']) ? '&search_term=' . urlencode($_POST['search_term']) : '' ?><?= isset($_POST['start_date']) ? '&start_date=' . urlencode($_POST['start_date']) : '' ?><?= isset($_POST['end_date']) ? '&end_date=' . urlencode($_POST['end_date']) : '' ?><?= isset($_POST['tutor_id']) ? '&tutor_id=' . urlencode($_POST['tutor_id']) : '' ?><?= isset($_POST['student_id']) ? '&student_id=' . urlencode($_POST['student_id']) : '' ?><?= isset($_POST['status']) ? '&status=' . urlencode($_POST['status']) : '' ?>">»</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
        // Dropdown functionality
        document.querySelectorAll('.expandable-row').forEach(row => {
            row.addEventListener('click', function() {
                this.classList.toggle('expanded');
                const detailsRow = this.nextElementSibling;
                if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                    detailsRow.style.display = 'table-row';
                    this.querySelector('.expand-icon').style.transform = 'rotate(90deg)';
                } else {
                    detailsRow.style.display = 'none';
                    this.querySelector('.expand-icon').style.transform = 'rotate(0deg)';
                }
            });
        });

        // Optional: Add form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            if (startDate && endDate && new Date(startDate) > new Date(endDate)) {
                alert('Start date must be before or equal to end date');
                e.preventDefault();
            }
        });
        
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
            document.getElementById('tutor_id').value = '';
            document.getElementById('student_id').value = '';
            document.getElementById('status').value = '';
            document.querySelector('input[name="search_term"]').value = '';
            document.querySelector('.search-form').submit();
        }
    </script>
</body>
</html>