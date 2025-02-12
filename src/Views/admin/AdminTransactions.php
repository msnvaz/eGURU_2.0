<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eGURU Admin</title>
    <link rel="icon" type="image/png" href="/images/eGURU_6.png">
    <link rel="stylesheet" href="/css/admin/Admin.css">
    <link rel="stylesheet" href="/css/admin/AdminHeader.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'AdminHeader.php'; ?>
    <?php include 'AdminNav.php'; ?>
    
    <div class="main">
        <table>
            <thead>
                <tr>
                    <th colspan="10" style="text-align: center; border-radius: 20px 20px 0 0;">Subject Overview</th>
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
                        <tr>
                            <td><?php echo htmlspecialchars($payment["payment_id"]); ?></td>
                            <td style="font-weight:650;"><?php echo htmlspecialchars($payment["points_paid"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["time_paid"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["session_id"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["scheduled_date"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["status"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["student_name"]); ?></td>
                            <td><?php echo htmlspecialchars($payment["tutor_name"]); ?></td>
                            <td>
                                <?php if ($payment["status"] !== 'refunded'): ?>
                                    <a href="/admin/transactions/refund/<?php echo htmlspecialchars($payment["payment_id"]); ?>" 
                                    class="btn btn-warning refund-button"
                                    onclick="return confirm('Are you sure you want to refund this transaction?')">
                                        Refund
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-success">Refunded</span>
                                <?php endif; ?>
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
</body>
</html>