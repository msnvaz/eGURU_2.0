// Global variables
let currentStep = 1;
let selectedAmount = 1000;
let selectedPoints = 100;
let selectedPaymentMethod = 'visa';

// Initialize the form
document.addEventListener('DOMContentLoaded', function() {
    // Set up custom amount input handling
    const customAmountInput = document.getElementById('custom-amount');
    customAmountInput.addEventListener('input', function() {
        const amount = parseInt(this.value) || 0;
        const points = calculatePoints(amount);
        document.getElementById('custom-points').value = points + ' points';
    });
    
    
});

// Step navigation functions
function goToStep(step) {
    // Validate current step before proceeding
    if (currentStep === 1 && step === 2) {
        if (selectedAmount < 500) {
            alert('Please select a package or enter a valid amount (minimum ₹500)');
            return;
        }
    }
    
    // Update current step
    currentStep = step;
    updateStepUI();
}

function updateStepUI() {
    // Hide all form sections and show the current one
    document.querySelectorAll('.form-section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById('step-' + currentStep).classList.add('active');
    
    // Update stepper UI
    document.querySelectorAll('.step').forEach((stepElement, index) => {
        const stepNumber = index + 1;
        stepElement.classList.remove('active', 'completed');
        
        if (stepNumber === currentStep) {
            stepElement.classList.add('active');
        } else if (stepNumber < currentStep) {
            stepElement.classList.add('completed');
        }
    });
    
    // Update progress bar
    const progressPercentage = ((currentStep - 1) / 3) * 100;
    document.getElementById('progress-bar').style.width = progressPercentage + '%';
}

// Package selection function
function selectPackage(element, points, amount) {
    // Remove selection from all packages
    document.querySelectorAll('.points-package').forEach(pkg => {
        pkg.classList.remove('selected');
    });
    
    // Add selection to clicked package
    element.classList.add('selected');
    
    // Update selected values
    selectedPoints = points;
    selectedAmount = amount;
    
    // Update hidden form fields
    document.getElementById('amount').value = amount;
    document.getElementById('points').value = points;
    
    // Go to next step
    goToStep(2);
}

// Payment method selection function
function selectPaymentMethod(element, method) {
    // Remove selection from all methods
    document.querySelectorAll('.payment-method').forEach(method => {
        method.classList.remove('selected');
    });
    
    // Add selection to clicked method
    element.classList.add('selected');
    selectedPaymentMethod = method;
    
    // Update the radio button
    element.querySelector('.payment-method-radio').checked = true;
    
    // Update card logo in the credit card display
    const cardLogo = document.getElementById('card-logo');
    cardLogo.innerHTML = method === 'visa' ? 
        '<i class="fab fa-cc-visa"></i>' : 
        (method === 'mastercard' ? '<i class="fab fa-cc-mastercard"></i>' : '<i class="fas fa-mobile-alt"></i>');
}

// Calculate points from amount (1 point = 10 currency units)
function calculatePoints(amount) {
    // Apply discounts based on amount
    if (amount >= 7500) {
        // 25% discount
        return Math.floor(amount / 7.5);
    } else if (amount >= 4000) {
        // 20% discount
        return Math.floor(amount / 8);
    } else if (amount >= 2700) {
        // 10% discount
        return Math.floor(amount / 9);
    } else {
        // Regular rate
        return Math.floor(amount / 10);
    }
}

// Review payment function
function reviewPayment() {
    // Get form values
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const cardNumber = document.getElementById('card-number').value;
    
    // Validate form
    if (!name || !email || !cardNumber || !document.getElementById('expiry-date').value || !document.getElementById('cvv').value) {
        alert('Please fill all the required fields');
        return;
    }
    
    // Check if we have a custom amount entered
    const customAmount = document.getElementById('custom-amount').value;
    if (customAmount && parseInt(customAmount) >= 500) {
        selectedAmount = parseInt(customAmount);
        selectedPoints = calculatePoints(selectedAmount);
        document.getElementById('amount').value = selectedAmount;
        document.getElementById('points').value = selectedPoints;
    }
    
    // Display values in review section
    document.getElementById('review-name').textContent = name;
    document.getElementById('review-email').textContent = email;
    document.getElementById('review-method').textContent = selectedPaymentMethod.charAt(0).toUpperCase() + selectedPaymentMethod.slice(1) + ' (•••• ' + cardNumber.replace(/\s/g, '').slice(-4) + ')';
    document.getElementById('review-points').textContent = selectedPoints + ' points';
    document.getElementById('review-amount').textContent = '₹' + selectedAmount.toLocaleString();
    
    // Go to review step
    goToStep(3);
}

// Show confirmation modal
function showConfirmationModal() {
    document.getElementById('modal-points').textContent = selectedPoints;
    document.getElementById('modal-amount').textContent = '₹' + selectedAmount.toLocaleString();
    
    document.getElementById('confirmation-overlay').classList.add('active');
    document.getElementById('confirmation-modal').classList.add('active');
}

// Close modal
function closeModal() {
    document.getElementById('confirmation-overlay').classList.remove('active');
    document.getElementById('confirmation-modal').classList.remove('active');
}

// Process payment
function processPayment() {
    // Close confirmation modal
    closeModal();
    
    // Show processing modal
    document.getElementById('processing-overlay').classList.add('active');
    document.getElementById('processing-modal').classList.add('active');
    
    // Simulate payment processing (in real implementation, this would call your server-side code)
    setTimeout(function() {
        // Update success page with details
        document.getElementById('success-points').textContent = selectedPoints;
        document.getElementById('success-transaction-id').textContent = 'TXN' + Math.floor(Math.random() * 1000000000);
        document.getElementById('success-amount').textContent = '₹' + selectedAmount.toLocaleString();
        
        // Hide processing modal
        document.getElementById('processing-overlay').classList.remove('active');
        document.getElementById('processing-modal').classList.remove('active');
        
        // Submit the form to server for actual processing
        document.getElementById('payment-form').action = "/student-process-payment";
        document.getElementById('payment-form').submit();
        
        // In this demo, instead of form submission, we'll show the success step
        // (In production, this would be redirected from the server after successful payment)
        goToStep(4);
    }, 2000);
}