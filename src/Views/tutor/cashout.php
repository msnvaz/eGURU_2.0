<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Out Points - Tutor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/tutor/cashout.css">
    <link rel="stylesheet" href="css/tutor/sidebar.css">
    
</head>
<body>

<?php $page="cashout"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>
    
    <div class="container">
        
        <div class="bodyform">
            <div class="cashout-container">
                <div class="cashout-header">
                    <h2>Cash Out Your Points</h2>
                    <p>Convert your earned points to real money</p>
                </div>
                
                <div class="cashout-body">
                    <!-- Display error message if any -->
                    <?php if (isset($_SESSION['cashout_error'])): ?>
                        <div class="error-message">
                            <?php 
                                echo $_SESSION['cashout_error']; 
                                unset($_SESSION['cashout_error']);
                            ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Points Balance -->
                    <div class="points-balance">
                        <div class="points-balance-label">Your Current Points Balance</div>
                        <div class="points-balance-value"><?php echo number_format($tutorInfo['tutor_points'] ?? 0); ?></div>
                    </div>
                    
                    <!-- Cashout Form -->
                    <h3 class="section-title">Request Cashout</h3>
                    
                    <form class="cashout-form" action="index.php?action=process_cashout" method="POST" id="cashout-form">
                        <div class="form-group">
                            <label for="points">Number of Points to Cash Out</label>
                            <input type="number" id="points" name="points" min="100" max="<?php echo $tutorInfo['tutor_points'] ?? 0; ?>" step="1" placeholder="Enter points amount (minimum 100)" required>
                            <div class="info-text">Minimum cashout: 100 points</div>
                        </div>
                        
                        <div class="cashout-details" id="cashout-details">
                            <div class="detail-item">
                                <div class="detail-label">Points to Cash Out</div>
                                <div class="detail-value" id="display-points">0</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Point Value</div>
                                <div class="detail-value">LKR <?php echo number_format($pointValue, 2); ?> per point</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Gross Amount</div>
                                <div class="detail-value" id="gross-amount">LKR 0.00</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">Platform Fee (<?php echo $platformFee; ?>%)</div>
                                <div class="detail-value" id="platform-fee">LKR 0.00</div>
                            </div>
                            
                            <div class="detail-item">
                                <div class="detail-label">You Will Receive</div>
                                <div class="detail-value" id="net-amount">LKR 0.00</div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Cash Out Now</button>
                    </form>
                    
                    <!-- Cashout History -->
                    <?php if (!empty($cashoutHistory)): ?>
                    <h3 class="section-title">Cashout History</h3>
                    <div class="cashout-history">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Points</th>
                                    <th>Amount</th>
                                    <th>Transaction ID</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cashoutHistory as $cashout): ?>
                                <tr>
                                    <td><?php echo date('Y-m-d', strtotime($cashout['created_at'] ?? 'now')); ?></td>
                                    <td><?php echo number_format($cashout['point_amount']); ?></td>
                                    <td>LKR <?php echo number_format($cashout['cash_value'], 2); ?></td>
                                    <td><?php echo $cashout['bank_transaction_id']; ?></td>
                                    <td><span class="status-completed">Completed</span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const pointsInput = document.getElementById('points');
        const displayPoints = document.getElementById('display-points');
        const grossAmount = document.getElementById('gross-amount');
        const platformFee = document.getElementById('platform-fee');
        const netAmount = document.getElementById('net-amount');
        const submitBtn = document.getElementById('submit-btn');
        
        const pointValue = <?php echo $pointValue; ?>;
        const platformFeePercentage = <?php echo $platformFee; ?>;
        const maxPoints = <?php echo $tutorInfo['tutor_points'] ?? 0; ?>;
        
        pointsInput.addEventListener('input', function() {
            const pointsToRedeem = parseInt(this.value) || 0;
            
            // Validate points
            if (pointsToRedeem < 100) {
                submitBtn.disabled = true;
                submitBtn.classList.add('btn-disabled');
                submitBtn.classList.remove('btn-primary');
            } else if (pointsToRedeem > maxPoints) {
                this.value = maxPoints;
                calculateValues(maxPoints);
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-disabled');
                submitBtn.classList.add('btn-primary');
            } else {
                calculateValues(pointsToRedeem);
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-disabled');
                submitBtn.classList.add('btn-primary');
            }
        });
        
        function calculateValues(points) {
            // Update display
            displayPoints.textContent = points.toLocaleString();
            
            // Calculate values
            const gross = points * pointValue;
            const fee = gross * (platformFeePercentage / 100);
            const net = gross - fee;
            
            // Update display
            grossAmount.textContent = 'LKR ' + gross.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            platformFee.textContent = 'LKR ' + fee.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
            netAmount.textContent = 'LKR ' + net.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }
        
        // Initialize with minimum value if available
        if (maxPoints >= 100) {
            pointsInput.value = 100;
            calculateValues(100);
            submitBtn.disabled = false;
            submitBtn.classList.remove('btn-disabled');
            submitBtn.classList.add('btn-primary');
        }
    });
    </script>
</body>
</html>