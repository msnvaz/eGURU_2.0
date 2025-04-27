<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success - Online Tuition</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
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
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
            margin-top: 100px;
            margin-left: 100px;
        }
        
        .success-header {
            background: #CBF1F9;
            padding: 2rem;
            text-align: center;
            color: black;
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--success);
            font-size: 40px;
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
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            color: var(--gray);
            font-weight: 500;
        }
        
        .detail-value {
            font-weight: 600;
            color: var(--dark);
        }
        ice
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
            background: #E14177;
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background: #e02362;
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
<?php $page = "payment"; ?>
<body>
    <?php include '../src/Views/student/header.php'; ?>
    <div class="container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        
        <div class="bodyform">
            <div class="success-container">
                <div class="success-header">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h2>Payment Successful!</h2>
                    <p>Your transaction has been completed</p>
                </div>
                
                <div class="success-body">
                    <div class="success-message">
                        Thank you for your purchase! Your points have been added to your account and are ready to use.
                    </div>
                    
                    <div class="success-details">
                        <div class="detail-item">
                            <div class="detail-label">Points Added</div>
                            <div class="detail-value"><?php echo $points ?? 0; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Transaction ID</div>
                            <div class="detail-value"><?php echo $transactionId ?? 'N/A'; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Amount Paid</div>
                            <div class="detail-value">Rs.<?php echo $paymentInfo['amount'] ?? 0; ?></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Date & Time</div>
                            <div class="detail-value"><?php echo date('Y-m-d H:i:s'); ?></div>
                        </div>
                    </div>
                    
                    <p>You can now use your points to book tutoring sessions!</p>
                    
                    <div class="actions">
                        <a href="/student-dashboard" class="btn btn-primary">Go to Dashboard</a>
                        
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
            const colors = ['#f72585', '#4361ee', '#4CC9F0', '#4CAF50', '#FFC107'];
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