<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link rel="stylesheet" href="/css/admin/AdminTransaction.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <br>
        <form method="POST" class="search-form">
            <div class="searchbar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search_term" placeholder='Search by Transaction ID, Student Name, or Tutor Name' required>
                <button type="submit" name="search">Search</button>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th colspan="9" style="text-align: center; border-radius: 20px 20px 0 0;">Subject Overview</th>
                </tr>
                <tr>
                    <th>Transaction ID</th>
                    <th>Points Paid</th>
                    <th>Time Paid</th>
                    <th>Session ID</th>
                    <th>Scheduled Date</th>
                    <th>Status</th>
                    <th>Student Name</th>
                    <th>Tutor Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($payments)): ?>
                    <?php foreach ($payments as $payment): ?>
                        <tr class="expandable-row">
                            <td>
                                <span class="expand-icon">►</span>
                                <?php echo htmlspecialchars($payment["payment_id"]); ?>
                            </td>
                            <td style="font-weight:650;"><?php echo htmlspecialchars($payment["payment_point_amount"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["payment_time"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["session_id"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["scheduled_date"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["session_status"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["student_first_name"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["tutor_first_name"]); ?></td>
                            <td>
                                <?php if ($payment["session_status"] !== 'okay'): ?>
                                    <button class="btn btn-warning refund-button" 
                                            data-payment-id="<?php echo htmlspecialchars($payment["payment_id"]); ?>">
                                        Refund
                                    </button>
                                <?php else: ?>
                                    <span class="badge bg-success">Refunded</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr class="details-row">
                            <td colspan="9">
                                <div class="details-content">
                                    <h4>Transaction Details</h4>
                                    <p><strong>Transaction ID : </strong> <?php echo htmlspecialchars($payment["payment_id"]); ?></p>
                                    <p><strong>Student Details : </strong> <a href="/admin-student-profile/<?= isset($payment['student_id']) ? htmlspecialchars($payment['student_id']) : ''; ?>">
                                                                            <?php echo htmlspecialchars($payment["student_first_name"]); ?>
                                                                            <?php echo htmlspecialchars($payment["student_last_name"]); ?>
                                                                            (<?php echo htmlspecialchars($payment["student_email"]); ?>)
                                                                            (<?php echo htmlspecialchars($payment["student_id"]); ?>)
                                    </a>
                                                                        </p>
                                    <p><strong>Tutor Details : </strong> <a href="/admin-tutor-profile/<?= isset($payment['tutor_id']) ? htmlspecialchars($payment['tutor_id']) : ''; ?>">
                                                                            <?php echo htmlspecialchars($payment["tutor_first_name"]); ?>
                                                                            <?php echo htmlspecialchars($payment["tutor_last_name"]); ?>
                                                                            (<?php echo htmlspecialchars($payment["tutor_email"]); ?>)
                                                                            (<?php echo htmlspecialchars($payment["tutor_id"]); ?>)
                                    </a>  
                                    </p>
                                    <p><strong>Session Date : </strong> <?php echo htmlspecialchars($payment["scheduled_date"]); ?></p>
                                    <p><strong>Payment Amount : </strong> <?php echo htmlspecialchars($payment["payment_point_amount"]); ?> points</p>
                                    <p><strong>Payment Status : </strong> <?php echo htmlspecialchars($payment["session_status"]); ?></p>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Refund Confirmation Modal -->
    <div id="refundModal" class="modal">
        <div class="modal-content">
            <h3>Confirm Refund</h3>
            <p>Are you sure you want to refund this transaction?</p>
            <p>Transaction ID: <span id="refundTransactionId"></span></p>
            <div class="modal-buttons">
                <button class="cancel-button" onclick="closeModal()">Cancel</button>
                <button class="confirm-button" onclick="confirmRefund()">Confirm Refund</button>
            </div>
        </div>
    </div>

    <script>
        // Dropdown functionality
        document.querySelectorAll('.expandable-row').forEach(row => {
            row.addEventListener('click', function() {
                this.classList.toggle('expanded');
                const detailsRow = this.nextElementSibling;
                if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });

        // Modal functionality
        const modal = document.getElementById('refundModal');
        let currentPaymentId = null;

        document.querySelectorAll('.refund-button').forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent row expansion when clicking refund
                currentPaymentId = this.dataset.paymentId;
                document.getElementById('refundTransactionId').textContent = currentPaymentId;
                modal.style.display = 'block';
            });
        });

        function closeModal() {
            modal.style.display = 'none';
        }

        function confirmRefund() {
            if (currentPaymentId) {
                window.location.href = `/admin-refund/${currentPaymentId}`;
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</body>
</html>
