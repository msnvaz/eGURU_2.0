<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <link rel="stylesheet" href="css/student/payment.css">
    <link rel="stylesheet" href="css/student/nav.css">
    <link rel="stylesheet" href="css/student/sidebar.css">
</head>
<?php $page="payment"; ?>
<body>
<?php include '../src/Views/student/header.php'; ?>
<div class="container">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        
<div class="bodyform">
<div class="payment-container">
        <!-- Step Header -->
        <div class="step-header">
            <div id="step-1" class="active" onclick="showStep(1)">1 PROCEED</div>
            <div id="step-2" onclick="showStep(2)">2 PAYMENT</div>
            <div id="step-3" onclick="showStep(3)">3 REVIEWS</div>
            <div id="step-4" onclick="showStep(4)">4 CONFIRM</div>
        </div>

        <!-- Step 1: Proceed -->
        <div class="form-section" id="form-step-1">
            <h3>Proceed to Payment</h3><br>
            <img src=images/student-uploads/points.jpg><br><br>
            <p>Make sure you have selected the appropriate plan before proceeding to payment.</p><br>
            <button class="submit-button" onclick="showStep(2)">Proceed to Payment</button>
        </div>

        <!-- Step 2: Payment -->
        <div class="form-section hidden" id="form-step-2">
<div class="form-group">
    <h3>Payment Method</h3>
    <div style="display: flex; align-items: center; gap: 10px;">
        <label>
            <input type="radio" name="payment-method" value="visa" checked>
            <img src="images/student-uploads/visa.jpg" alt="Visa" style="width: 50px; height: auto;">
        </label>
        <label>
            <input type="radio" name="payment-method" value="mastercard">
            <img src="images/student-uploads/mastercard.jpg" alt="MasterCard" style="width: 50px; height: auto;">
        </label>
        
    </div>
</div>

            <h3>Payment Details</h3><br>
            <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" placeholder="Enter your email address" required>
                </div>
                <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" placeholder="Enter your card number" required>
                </div>
                <div class="form-group">
                    <label for="expiry-date">Expiry Date</label>
                    <input type="month" id="expiry-date" required>
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="password" id="cvv" placeholder="Enter CVV" required>
                </div>
                
            <div class="form-group">
                    <label for="amount">Payment Amount (INR)</label>
                    <input type="number" id="amount" placeholder="Enter amount (e.g., 10000)" required>
                </div>
                <button class="submit-button" onclick="showStep(3)">Review Payment</button>
            </form>
        </div>
            

        <!-- Step 3: Reviews -->
<div class="form-section hidden" id="form-step-3">
    <h3>Review Your Details</h3><br>
    <p>Please verify the information below:</p><br>
    <ul>
        <li><strong>Full Name:</strong> <span id="review-name"></span></li><br><br>
        <li><strong>Email:</strong> <span id="review-email"></span></li><br><br>
        <li><strong>Card Number:</strong> <span id="review-card-number"></span></li><br><br>
        <li><strong>Expiry Date:</strong> <span id="review-expiry-date"></span></li><br><br>
        <!--<li><strong>Country:</strong> <span id="review-country"></span></li>-->
        <li><strong>Payment Amount (INR):</strong> <span id="review-amount"></span></li><br><br>
    </ul>
    <p>If everything looks correct, proceed to confirmation.</p>
    <button class="submit-button" onclick="showStep(4)">Proceed to Confirmation</button>
</div>
        

<!-- Step 4: Confirmation -->
<div class="form-section hidden" id="form-step-4">
                    <h3>Confirmation</h3><br>
                    <p>Please confirm your payment to proceed.</p>
                    <button class="submit-button" onclick="confirmPayment()">Confirm Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-overlay"></div>
<div id="confirmation-modal" class="hidden">
    <div class="modal-content">
        <h3>Payment Successful</h3>
        <img src="images/student-uploads/tick.png" alt="Success" style="width: 50px;">
        <p>Your payment has been processed successfully!</p>
        <p>You have earned <span id="modal-earned-points"></span> points!</p>
        <button onclick="closeModal()">Close</button>
    </div>
</div>

<script src="js/student/payments.js"></script>

</body>
</html>
