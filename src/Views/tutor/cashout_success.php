<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if cashout info exists in session
if (!isset($_SESSION['cashout_info'])) {
    // Redirect back to cashout page if no cashout info found
    header('Location: index.php?action=cashout');
    exit;
}

$cashoutInfo = $_SESSION['cashout_info'];
$points = $cashoutInfo['points'] ?? 0;
$grossValue = $cashoutInfo['gross_value'] ?? 0;
$feeAmount = $cashoutInfo['fee_amount'] ?? 0;
$netValue = $cashoutInfo['net_value'] ?? 0;
$feePercentage = $cashoutInfo['fee_percentage'] ?? 5;

// Get transaction ID from session if available
$transactionId = isset($_SESSION['transaction_id']) ? $_SESSION['transaction_id'] : 'TXN' . time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashout Success - Tutor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/tutor/sidebar.css">
    <style>
        :root {
            --primary: #1e3a8a;;
            --primary-dark: #1e3a8a;
            --secondary: #7209b7;
            --success: #4CAF50;
            --danger: #f72585;
            --warning: #ffc107;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --card-shadow: 0 10px 20px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: #f5f7fe;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            width:1000px;
            margin-top: 5%;
            margin-left: 25%;
            display: flex;
            min-height: calc(100vh - 70px);
        }
        
        .bodyform {
            flex: 1;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .success-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
        }
        
        .success-header {
            background: #4CAF50;
            padding: 1.5rem;
            text-align: center;
            color: white;
        }
        
        .success-icon {
            width: 30px;
            height: 30px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--success);
            font-size: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            animation: bounce 1s ease;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {transform: translateY(0);}
            40% {transform: translateY(-20px);}
            60% {transform: translateY(-10px);}
        }
        
        .success-body {
            padding: 2rem;
            text-align: center;
        }
        
        .success-message {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: var(--gray);
        }
        
        .success-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem 2rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
            font-weight: bold;
        }
        
        .detail-label {
    color: var(--gray);
    font-weight: 500;
    font-size: 0.95rem;
}

.detail-value {
    font-weight: 600;
    color: var(--dark);
    font-size: 1.05rem;
}

@media (max-width: 768px) {
    .detail-grid {
        grid-template-columns: 1fr;
    }
}
        
        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: #1e3a8a;
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background:rgb(23, 46, 109);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.2);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .btn-outline:hover {
            background: rgba(67, 97, 238, 0.05);
        }
        
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background-color: var(--primary);
            animation: confetti-fall 5s linear infinite;
            z-index: 9999;
            border-radius: 2px;
            transform: rotate(45deg);
        }
        
        @keyframes confetti-fall {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
        
        /* Responsive styles */
        @media (max-width: 768px) {
            .bodyform {
                padding: 1rem;
            }
            
            .success-container {
                width: 95%;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>


<body>

<?php $page="cashout"; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Header -->
<?php include '../src/Views/tutor/header.php'; ?>
    
    <div class="container">
        
        <div class="bodyform">
            <div class="success-container">
                <div class="success-header">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2>Cashout Successful!</h2>
                    <p>Your points have been converted to cash</p>
                </div>
                
                <div class="success-body">
                    <div class="success-message">
                        Your cashout request has been processed successfully. The funds will be transferred to your registered account within 2-3 business days.
                    </div>
                    
                    <div class="success-details">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <div class="detail-label">Points Cashed Out</div>
                                <div class="detail-value"><?php echo number_format($points); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Gross Amount</div>
                                <div class="detail-value">LKR <?php echo number_format($grossValue, 2); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Platform Fee (<?php echo $feePercentage; ?>%)</div>
                                <div class="detail-value">LKR <?php echo number_format($feeAmount, 2); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Transaction ID</div>
                                <div class="detail-value"><?php echo $transactionId; ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Date & Time</div>
                                <div class="detail-value"><?php echo date('Y-m-d H:i:s'); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Net Amount</div>
                                <div class="detail-value">LKR <?php echo number_format($netValue, 2); ?></div>
                            </div>
                        </div>
                    </div>

                    
                    <p>Thank you for using our platform. You can track the status of your cashout in your dashboard.</p>
                    
                    <div class="actions">
                        <a href="/tutor-dashboard" class="btn btn-primary">Go to Dashboard</a>
                        <a href="index.php?action=cashout" class="btn btn-outline">Cash Out Again</a>
                    </div>
                </div>
            </div>
            
            <!-- Confetti animation elements will be added by JS -->
        </div>
    </div>
    
    <script>
        // Create confetti animation
        document.addEventListener('DOMContentLoaded', function() {
            createConfetti();
            
            // Auto-remove confetti after 5 seconds
            setTimeout(function() {
                const confetti = document.querySelectorAll('.confetti');
                confetti.forEach(c => c.remove());
            }, 5000);
        });
        
        function createConfetti() {
            const colors = ['#4361ee', '#4CAF50', '#ffc107', '#f72585', '#7209b7'];
            const confettiCount = 100;
            
            for (let i = 0; i < confettiCount; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                
                // Random positioning and styling
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = Math.random() * 10 + 5 + 'px';
                confetti.style.height = Math.random() * 10 + 5 + 'px';
                confetti.style.opacity = Math.random() + 0.5;
                
                // Random animation duration and delay
                confetti.style.animationDuration = Math.random() * 3 + 2 + 's';
                confetti.style.animationDelay = Math.random() * 5 + 's';
                
                document.body.appendChild(confetti);
            }
        }
    </script>
</body>
</html>