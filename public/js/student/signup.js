//signup validation
document.addEventListener("DOMContentLoaded", function () {
    // Select the form and input fields
    const form = document.getElementById("signupForm");
    const passwordField = document.getElementById("password");
    const confirmPasswordField = document.getElementById("confirmPassword");
    const emailField = document.getElementById("email");
    const phoneField = document.getElementById("phone");
    const errorMessageDiv = document.getElementById("error-message");

    // Mocked existing emails (replace this with a server-side check)
    const existingEmails = ["test@example.com", "user@example.com"];

    // Add submit event listener
    form.addEventListener("submit", function (event) {
        let errorMessage = "";

        // Validate password length
        if (passwordField.value.length < 8) {
            errorMessage = "Password must be at least 8 characters long.";
        }

        // Validate password match
        if (passwordField.value !== confirmPasswordField.value) {
            errorMessage = "Passwords do not match.";
        }

        // Validate email uniqueness
        if (existingEmails.includes(emailField.value)) {
            errorMessage = "This email is already in use.";
        }

        // Validate phone number
        const phonePattern = /^[0-9]+$/;
        if (!phonePattern.test(phoneField.value)) {
            errorMessage = "Phone number must contain only numbers.";
        }

        // Display error or allow submission
        if (errorMessage) {
            event.preventDefault(); // Prevent form submission
            errorMessageDiv.textContent = errorMessage; // Show error message
        } else {
            errorMessageDiv.textContent = ""; // Clear error message
        }
    });
});