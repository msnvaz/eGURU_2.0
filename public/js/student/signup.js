const errorMessages = {
    firstname: 'First name should be 2-30 letters',
    lastname: 'Last name should be 2-30 letters',
    email: 'Please enter a valid email address',
    password: 'Password must be at least 8 characters with 1 letter, 1 number, and 1 special character',
    'confirm-password': 'Passwords do not match',
    date: 'Please select your date of birth',
    tel: 'Please enter a valid phone number',
    terms: 'You must accept the terms and conditions'
};

function validateField(field, pattern) {
    if (!pattern) return true;
    return pattern.test(field.value);
}

function showError(field, message) {
    const errorElement = field.parentElement.querySelector('.error-message');
    field.classList.add('error');
    field.classList.remove('valid');
    errorElement.textContent = message;
}

function showSuccess(field) {
    const errorElement = field.parentElement.querySelector('.error-message');
    field.classList.remove('error');
    field.classList.add('valid');
    errorElement.textContent = '';
}

function updatePasswordStrength(password) {
    const strengthBar = document.querySelector('.password-strength');
    const strength = {
        0: 'Too weak',
        1: 'Weak',
        2: 'Medium',
        3: 'Strong'
    };

    let score = 0;
    if (password.length >= 8) score++;
    if (password.match(/[A-Z]/)) score++;
    if (password.match(/[0-9]/)) score++;
    if (password.match(/[^A-Za-z0-9]/)) score++;

    const colors = {
        0: '#ff4444',
        1: '#ffbb33',
        2: '#00c851',
        3: '#007e33'
    };

    strengthBar.style.width = `${(score / 4) * 100}%`;
    strengthBar.style.backgroundColor = colors[score];
}


document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signupForm');
    const inputs = form.querySelectorAll('input');

    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (input.type === 'password' && input.id === 'password') {
                updatePasswordStrength(input.value);
            }

            if (patterns[input.id]) {
                if (validateField(input, patterns[input.id])) {
                    showSuccess(input);
                } else {
                    showError(input, errorMessages[input.id]);
                }
            }

            
            if (input.id === 'confirm-password') {
                const password = document.getElementById('password').value;
                if (input.value === password) {
                    showSuccess(input);
                } else {
                    showError(input, errorMessages['confirm-password']);
                }
            }
        });
    });

    
    window.togglePassword = function(fieldId) {
        const field = document.getElementById(fieldId);
        const type = field.type === 'password' ? 'text' : 'password';
        field.type = type;
    };

    
});