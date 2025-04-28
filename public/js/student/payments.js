
let currentStep = 1;
let selectedAmount = 1000;
let selectedPoints = 100;
let selectedPaymentMethod = 'visa';


document.addEventListener('DOMContentLoaded', function() {
    
    const customAmountInput = document.getElementById('custom-amount');
    customAmountInput.addEventListener('input', function() {
        const amount = parseInt(this.value) || 0;
        const points = calculatePoints(amount);
        document.getElementById('custom-points').value = points + ' points';
    });
    
    
});


function goToStep(step) {
    
    if (currentStep === 1 && step === 2) {
        if (selectedAmount < 500) {
            alert('Please select a package or enter a valid amount (minimum ₹500)');
            return;
        }
    }
    
    
    currentStep = step;
    updateStepUI();
}

function updateStepUI() {
    
    document.querySelectorAll('.form-section').forEach(section => {
        section.classList.remove('active');
    });
    document.getElementById('step-' + currentStep).classList.add('active');
    
    
    document.querySelectorAll('.step').forEach((stepElement, index) => {
        const stepNumber = index + 1;
        stepElement.classList.remove('active', 'completed');
        
        if (stepNumber === currentStep) {
            stepElement.classList.add('active');
        } else if (stepNumber < currentStep) {
            stepElement.classList.add('completed');
        }
    });
    
    
    const progressPercentage = ((currentStep - 1) / 3) * 100;
    document.getElementById('progress-bar').style.width = progressPercentage + '%';
}


function selectPackage(element, points, amount) {
    
    document.querySelectorAll('.points-package').forEach(pkg => {
        pkg.classList.remove('selected');
    });
    
    
    element.classList.add('selected');
    
    
    selectedPoints = points;
    selectedAmount = amount;
    
    
    document.getElementById('amount').value = amount;
    document.getElementById('points').value = points;
    
    
    goToStep(2);
}


function selectPaymentMethod(element, method) {
    
    document.querySelectorAll('.payment-method').forEach(method => {
        method.classList.remove('selected');
    });
    
    
    element.classList.add('selected');
    selectedPaymentMethod = method;
    
    
    element.querySelector('.payment-method-radio').checked = true;
    
    
    const cardLogo = document.getElementById('card-logo');
    cardLogo.innerHTML = method === 'visa' ? 
        '<i class="fab fa-cc-visa"></i>' : 
        (method === 'mastercard' ? '<i class="fab fa-cc-mastercard"></i>' : '<i class="fas fa-mobile-alt"></i>');
}


function calculatePoints(amount) {
    
    if (amount >= 7500) {
        
        return Math.floor(amount / 7.5);
    } else if (amount >= 4000) {
        
        return Math.floor(amount / 8);
    } else if (amount >= 2700) {
        
        return Math.floor(amount / 9);
    } else {
        
        return Math.floor(amount / 10);
    }
}


function reviewPayment() {
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const cardNumber = document.getElementById('card-number').value;
    
    
    if (!name || !email || !cardNumber || !document.getElementById('expiry-date').value || !document.getElementById('cvv').value) {
        alert('Please fill all the required fields');
        return;
    }
    
    
    const customAmount = document.getElementById('custom-amount').value;
    if (customAmount && parseInt(customAmount) >= 500) {
        selectedAmount = parseInt(customAmount);
        selectedPoints = calculatePoints(selectedAmount);
        document.getElementById('amount').value = selectedAmount;
        document.getElementById('points').value = selectedPoints;
    }
    
    
    document.getElementById('review-name').textContent = name;
    document.getElementById('review-email').textContent = email;
    document.getElementById('review-method').textContent = selectedPaymentMethod.charAt(0).toUpperCase() + selectedPaymentMethod.slice(1) + ' (•••• ' + cardNumber.replace(/\s/g, '').slice(-4) + ')';
    document.getElementById('review-points').textContent = selectedPoints + ' points';
    document.getElementById('review-amount').textContent = '₹' + selectedAmount.toLocaleString();
    
   
    goToStep(3);
}


function showConfirmationModal() {
    document.getElementById('modal-points').textContent = selectedPoints;
    document.getElementById('modal-amount').textContent = '₹' + selectedAmount.toLocaleString();
    
    document.getElementById('confirmation-overlay').classList.add('active');
    document.getElementById('confirmation-modal').classList.add('active');
}


function closeModal() {
    document.getElementById('confirmation-overlay').classList.remove('active');
    document.getElementById('confirmation-modal').classList.remove('active');
}


function processPayment() {
    
    closeModal();
    
    
    document.getElementById('processing-overlay').classList.add('active');
    document.getElementById('processing-modal').classList.add('active');
    
    
    setTimeout(function() {
        
        document.getElementById('success-points').textContent = selectedPoints;
        document.getElementById('success-transaction-id').textContent = 'TXN' + Math.floor(Math.random() * 1000000000);
        document.getElementById('success-amount').textContent = '₹' + selectedAmount.toLocaleString();
        
        
        document.getElementById('processing-overlay').classList.remove('active');
        document.getElementById('processing-modal').classList.remove('active');
        
        
        document.getElementById('payment-form').action = "/student-process-payment";
        document.getElementById('payment-form').submit();
        
        
        goToStep(4);
    }, 2000);
}