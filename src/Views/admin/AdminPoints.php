<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin - Points Transactions</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/admin/AdminPoints.css">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <br>
            <?php
                $purchaseCount = 0;
                $purchasePoints = 0;
                $purchaseValue = 0;
                
                $cashoutCount = 0;
                $cashoutPoints = 0;
                $cashoutValue = 0;
                $platformRate = 0.05; // 5% platform rate
                $platformRevenue = 0;
                
                foreach ($records as $record) {
                    if ($record['transaction_type'] === 'purchase') {
                        $purchaseCount++;
                        $purchasePoints += $record['point_amount'];
                        $purchaseValue += $record['cash_value'];
                    } else {
                        $cashoutCount++;
                        $cashoutPoints += $record['point_amount'];
                        $cashoutValue += $record['cash_value'];
                    }
                }
                $platformRevenue = $purchaseValue + ($cashoutValue * $platformRate);
                //echo $purchaseCount;
            ?>
        
        <form method="POST" class="search-form" style="font-size: 12px;">
            <div class="date-range-container" style="display: flex; gap: 10px; width:90%;">
                <!-- Transaction Type Filter -->
                <div class="filter-item">
                    <label for="transaction_type">Transaction Type:</label>
                    <select name="transaction_type" id="transaction_type">
                        <option value="">All Transactions</option>
                        <option value="purchase" <?= (isset($_POST['transaction_type']) && $_POST['transaction_type'] == 'purchase') ? 'selected' : '' ?>>Student Purchases</option>
                        <option value="cashout" <?= (isset($_POST['transaction_type']) && $_POST['transaction_type'] == 'cashout') ? 'selected' : '' ?>>Tutor Cashouts</option>
                    </select>
                </div>
                
                <!-- Points Range Filter -->
                <div class="filter-item">
                    <label for="points_min">Points Min:</label>
                    <input type="number" name="points_min" id="points_min" min="0" 
                        value="<?= isset($_POST['points_min']) ? htmlspecialchars($_POST['points_min']) : '' ?>">
                </div>
                
                <div class="filter-item">
                    <label for="points_max">Points Max:</label>
                    <input type="number" name="points_max" id="points_max" min="0" 
                        value="<?= isset($_POST['points_max']) ? htmlspecialchars($_POST['points_max']) : '' ?>">
                </div>
                
                <!-- Tutor Selection (for cashouts) -->
                <div class="filter-item">
                    <label for="tutor_id">Tutor (for cashouts):</label>
                    <select name="tutor_id" id="tutor_id">
                        <option value="">All Tutors</option>
                        <?php foreach ($tutors as $tutor) : ?>
                            <option value="<?= htmlspecialchars($tutor['tutor_id']) ?>"
                                <?= (isset($_POST['tutor_id']) && $_POST['tutor_id'] == $tutor['tutor_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tutor['tutor_full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Student Selection (for purchases) -->
                <div class="filter-item">
                    <label for="student_id">Student (for purchases):</label>
                    <select name="student_id" id="student_id">
                        <option value="">All Students</option>
                        <?php foreach ($students as $student) : ?>
                            <option value="<?= htmlspecialchars($student['student_id']) ?>"
                                <?= (isset($_POST['student_id']) && $_POST['student_id'] == $student['student_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($student['student_full_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="searchbar" style="margin-top: 10px;"> 
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search_term" placeholder="Search by Name, Email, Transaction ID" style="border-color:rgba(41, 50, 65, 0);" 
                       value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : '' ?>" >
                <button type="submit" name="search" value="1">Search</button>
                <button type="submit" onclick="printTable()">PDF</button>
                <button type="button" onclick="resetFilters()" class="reset-btn">Reset</button>
            </div>
        </form>
        <!-- Points Summary -->
        <div class="stats-section">
            <div class="stat-card">
                <h3>Total Student Purchases</h3>
                <p class="stat-number"><?= $purchaseCount ?></p>
                
            </div>
            <div class="stat-card">
                <h3>Total Points Purchased</h3>
                <p class="stat-number"><?= $purchasePoints ?></p>
                
            </div>
            <div class="stat-card">
                <h3>Total Purchase Value</h3>
                <p class="stat-number">Rs.<?= number_format($purchaseValue, 0) ?></p>
                
            </div>
            <div class="stat-card">
                <h3>Total Tutor Cashouts</h3>
                <p class="stat-number"><?= $cashoutCount ?></p>
                
            </div>
            <div class="stat-card">
                <h3>Total Points Cashed Out</h3>
                <p class="stat-number"><?= $cashoutPoints ?></p>
                
            </div>
            <div class="stat-card">
                <h3>Total Cashout Value</h3>
                <p class="stat-number">Rs.<?= number_format($cashoutValue, 0) ?></p>
                
            </div>
            <div class="stat-card">
                <h3>Platform Revenue</h3>
                <p class="stat-number">Rs.<?= number_format($platformRevenue, 0) ?></p>
            </div>
        </div>

        <div class="points-table" id="points-table" >
        <table>
            <thead>
                <tr>
                    <th colspan="8" style="text-align: center;border-radius: 20px 20px 0 0;font-size:14px;margin:0;">Points Transactions</th>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>User</th>
                    <th>Points</th>
                    <th>Cash Value</th>
                    <th>Transaction ID</th>
                    <th>Transaction Date</th>
                    <th>Transaction Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)) : ?>
                    <?php
                    // Pagination setup
                    $perPage = 20; // 20 records per page
                    $total = count($records);
                    $pages = ceil($total / $perPage);
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $page = max(1, min($page, $pages)); // Ensure page is within valid range
                    $offset = ($page - 1) * $perPage;
                    $paginatedRecords = array_slice($records, $offset, $perPage);
                    ?>
                    
                    <?php foreach ($paginatedRecords as $record) : ?>
                        <tr class="expandable-row transaction-<?= htmlspecialchars($record['transaction_type']) ?>">
                            <td>
                                <span class="expand-icon">►</span>
                                <?= htmlspecialchars($record['transaction_id']) ?>
                            </td>
                            <td>
                                <?= ucfirst(htmlspecialchars($record['transaction_type'])) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($record['first_name'] . ' ' . $record['last_name']) ?>
                            </td>
                            <td><?= htmlspecialchars($record['point_amount']) ?></td>
                            <td>Rs.<?= number_format($record['cash_value'], 2) ?></td>
                            <td><?= htmlspecialchars($record['bank_transaction_id']) ?></td>
                            <td><?= htmlspecialchars($record['transaction_date']) ?></td>
                            <td><?= htmlspecialchars($record['transaction_time']) ?></td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="8">
                                <div class="details-content">
                                    <div class="details-grid">
                                        <div class="details-grid-item">
                                            <h4>Transaction Information</h4>
                                            <p><strong>Transaction ID:</strong> <?= htmlspecialchars($record['transaction_id']) ?></p>
                                            <p><strong>Type:</strong> <?= ucfirst(htmlspecialchars($record['transaction_type'])) ?></p>
                                            <p><strong>Points Amount:</strong> <?= htmlspecialchars($record['point_amount']) ?></p>
                                            <p><strong>Cash Value:</strong> Rs.<?= number_format($record['cash_value'], 2) ?></p>
                                            <p><strong>Bank Transaction ID:</strong> <?= htmlspecialchars($record['bank_transaction_id']) ?></p>
                                            <p><strong>Transaction Date &Time:</strong> <?= htmlspecialchars($record['transaction_time']) ?></p>
                                            <p><strong>Points to Cash Ratio:</strong> 
                                                <?= $record['point_amount'] ? (number_format($record['cash_value'] / $record['point_amount'], 2)) : 'N/A' ?> : 1
                                            </p>
                                        </div>
                                        <div class="details-grid-item">
                                            <h4>User Information</h4>
                                            <?php if ($record['transaction_type'] === 'purchase'): ?>
                                                <p><strong>Student ID:</strong> <?= htmlspecialchars($record['user_id']) ?></p>
                                                <p><strong>Student Name:</strong> <?= htmlspecialchars($record['first_name'] . ' ' . $record['last_name']) ?></p>
                                                <p><strong>Student Email:</strong> <?= htmlspecialchars($record['email']) ?></p>
                                            <?php else: ?>
                                                <p><strong>Tutor ID:</strong> <?= htmlspecialchars($record['user_id']) ?></p>
                                                <p><strong>Tutor Name:</strong> <?= htmlspecialchars($record['first_name'] . ' ' . $record['last_name']) ?></p>
                                                <p><strong>Tutor Email:</strong> <?= htmlspecialchars($record['email']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="6">No transactions found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        
        <?php if (!empty($records) && $pages > 1): ?>
        <div class="pagination">
            <?php
            // Previous button
            if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?><?= isset($_GET['transaction_type']) ? '&transaction_type=' . urlencode($_GET['transaction_type']) : '' ?>">Previous</a>
            <?php else: ?>
                <span class="disabled">Previous</span>
            <?php endif; ?>
            
            <?php
            // Page numbers
            $startPage = max(1, $page - 2);
            $endPage = min($pages, $page + 2);
            
            if ($startPage > 1): ?>
                <a href="?page=1<?= isset($_GET['transaction_type']) ? '&transaction_type=' . urlencode($_GET['transaction_type']) : '' ?>">1</a>
                <?php if ($startPage > 2): ?>
                    <span>...</span>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="current"><?= $i ?></span>
                <?php else: ?>
                    <a href="?page=<?= $i ?><?= isset($_GET['transaction_type']) ? '&transaction_type=' . urlencode($_GET['transaction_type']) : '' ?>"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if ($endPage < $pages): ?>
                <?php if ($endPage < $pages - 1): ?>
                    <span>...</span>
                <?php endif; ?>
                <a href="?page=<?= $pages ?><?= isset($_GET['transaction_type']) ? '&transaction_type=' . urlencode($_GET['transaction_type']) : '' ?>"><?= $pages ?></a>
            <?php endif; ?>
            
            <?php
            // Next button
            if ($page < $pages): ?>
                <a href="?page=<?= $page + 1 ?><?= isset($_GET['transaction_type']) ? '&transaction_type=' . urlencode($_GET['transaction_type']) : '' ?>">Next</a>
            <?php else: ?>
                <span class="disabled">Next</span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <script>
        // Toggle row expansion
        document.querySelectorAll('.expandable-row').forEach(row => {
            row.addEventListener('click', function() {
                this.classList.toggle('expanded');
                const detailsRow = this.nextElementSibling;
                if (detailsRow.style.display === 'table-row') {
                    detailsRow.style.display = 'none';
                } else {
                    detailsRow.style.display = 'table-row';
                }
            });
        });
        
        // Reset filters
        function resetFilters() {
            document.getElementById('transaction_type').value = '';
            document.getElementById('points_min').value = '';
            document.getElementById('points_max').value = '';
            document.getElementById('tutor_id').value = '';
            document.getElementById('student_id').value = '';
            document.querySelector('input[name="search_term"]').value = '';
            document.querySelector('form.search-form').submit();
        }
        
        // Show transaction type specific filters
        document.getElementById('transaction_type').addEventListener('change', function() {
            const selectedType = this.value;
            if (selectedType === 'purchase') {
                document.getElementById('student_id').parentElement.style.display = 'block';
                document.getElementById('tutor_id').parentElement.style.display = 'none';
            } else if (selectedType === 'cashout') {
                document.getElementById('student_id').parentElement.style.display = 'none';
                document.getElementById('tutor_id').parentElement.style.display = 'block';
            } else {
                document.getElementById('student_id').parentElement.style.display = 'block';
                document.getElementById('tutor_id').parentElement.style.display = 'block';
            }
        });
        
        // Trigger change event on page load to set initial visibility
        document.addEventListener('DOMContentLoaded', function() {
            const event = new Event('change');
            document.getElementById('transaction_type').dispatchEvent(event);
        });

        function printTable() {
            var printContents = document.getElementById('points-table').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
        //   document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
</body>
</html>