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
                            <td style="font-weight:650;"><?php echo htmlspecialchars($payment["points_paid"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["time_paid"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["session_id"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["scheduled_date"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["status"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["student_name"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["tutor_name"]); ?></td>
                            <td>
                                <?php if ($payment["status"] !== 'refunded'): ?>
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
                                    <p><strong>Student Details : </strong> <?php echo htmlspecialchars($payment["student_name"]); ?></p>
                                    <p><strong>Tutor Details : </strong> <?php echo htmlspecialchars($payment["tutor_name"]); ?></p>
                                    <p><strong>Session Date : </strong> <?php echo htmlspecialchars($payment["scheduled_date"]); ?></p>
                                    <p><strong>Payment Amount : </strong> <?php echo htmlspecialchars($payment["points_paid"]); ?> points</p>
                                    <p><strong>Payment Status : </strong> <?php echo htmlspecialchars($payment["status"]); ?></p>
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