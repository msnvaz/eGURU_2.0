<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = "payment";
include __DIR__ . '/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Points - Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/student/payment.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
    
</head>
<body>
    
    <div class="container">
        
        <?php include 'sidebar.php'; ?>
        
        <div class="bodyform">
            
            <?php if (isset($_SESSION['payment_error'])): ?>
                <div class="error-message">
                    <?php 
                        echo $_SESSION['payment_error']; 
                        unset($_SESSION['payment_error']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="payment-container">
                
                <div class="stepper">
                    <div class="step step-1 active">
                        <div class="step-number">1</div>
                        <div class="step-label">SELECT PLAN</div>
                    </div>
                    <div class="step step-2">
                        <div class="step-number">2</div>
                        <div class="step-label">PAYMENT</div>
                    </div>
                    <div class="step step-3">
                        <div class="step-number">3</div>
                        <div class="step-label">CONFIRMATION</div>
                    </div>
                    <div class="step-progress">
                        <div class="step-progress-bar" id="progress-bar"></div>
                    </div>
                </div>

                
                <div class="form-section active" id="step-1">
                    <h3>Choose Your Points Package</h3>
                    <p>Select a points package that fits your tutoring needs:</p>
                    
                    <div class="points-packages">
                        <div class="points-package" data-points="100" data-price="1000">
                            <div class="package-points">100</div>
                            <div class="package-price">LKR 1,000</div>
                            <div class="package-description">Perfect for starting out</div>
                            <button class="btn btn-next package-select-btn">Select</button>
                        </div>
                        
                        <div class="points-package" data-points="300" data-price="2700">
                            <div class="package-points">300</div>
                            <div class="package-price">LKR 2,700</div>
                            <div class="package-description">10% savings on points</div>
                            <button class="btn btn-next package-select-btn">Select</button>
                        </div>
                        
                        <div class="points-package" data-points="500" data-price="4000">
                            <div class="package-best-value">BEST VALUE</div>
                            <div class="package-points">500</div>
                            <div class="package-price">LKR 4,000</div>
                            <div class="package-description">20% savings on points</div>
                            <button class="btn btn-next package-select-btn">Select</button>
                        </div>
                        
                        <div class="points-package" data-points="1000" data-price="7500">
                            <div class="package-points">1000</div>
                            <div class="package-price">LKR 7,500</div>
                            <div class="package-description">25% savings on points</div>
                            <button class="btn btn-next package-select-btn">Select</button>
                        </div>
                    </div>
                    
                    <h3>Custom Amount</h3>
                    <div class="form-group">
                        <label for="custom-amount">Enter Amount (LKR)</label>
                        <input type="number" id="custom-amount" min="500" step="100" placeholder="Minimum LKR 500">
                    </div>
                    
                    <div class="form-group">
                        <label for="custom-points">Points to receive</label>
                        <input type="text" id="custom-points" readonly>
                    </div>
                    
                    <form id="payment-form" action="index.php?action=checkout" method="POST">
                        <input type="hidden" id="amount" name="amount" value="">
                        <input type="hidden" id="points" name="points" value="">
                        
                        <div class="btn-container">
                            <button type="button" id="custom-payment-btn" class="btn btn-next">Proceed with Custom Amount</button>
                        </div>
                    </form>
                </div>
                
                
                <?php if (!empty($paymentHistory)): ?>
                <div class="payment-history">
                    <h3>Payment History</h3>
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Date</th>
                                <th>Points</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paymentHistory as $payment): ?>
                            <tr>
                                <td><?php echo $payment['payment_id']; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($payment['created_at'] ?? 'now')); ?></td>
                                <td><?php echo $payment['point_amount']; ?></td>
                                <td>LKR <?php echo $payment['cash_value']; ?></td>
                                <td><?php echo $payment['bank_transaction_id']; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const packageButtons = document.querySelectorAll('.package-select-btn');
        packageButtons.forEach(button => {
            button.addEventListener('click', function() {
                const package = this.closest('.points-package');
                const points = package.getAttribute('data-points');
                const price = package.getAttribute('data-price');
                
                document.getElementById('amount').value = price;
                document.getElementById('points').value = points;
                document.getElementById('payment-form').submit();
            });
        });
        
        
        const customAmountInput = document.getElementById('custom-amount');
        const customPointsInput = document.getElementById('custom-points');
        const customPaymentBtn = document.getElementById('custom-payment-btn');
        
        customAmountInput.addEventListener('input', function() {
            const amount = parseInt(this.value) || 0;
            
            const points = Math.floor(amount / 10);
            customPointsInput.value = points > 0 ? points : '';
        });
        
        customPaymentBtn.addEventListener('click', function() {
            const amount = parseInt(customAmountInput.value) || 0;
            const points = Math.floor(amount / 10);
            
            if (amount < 500) {
                alert('Please enter a minimum amount of LKR 500');
                return;
            }
            
            document.getElementById('amount').value = amount;
            document.getElementById('points').value = points;
            document.getElementById('payment-form').submit();
        });
    });
    </script>
</body>
</html>