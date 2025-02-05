
    // Logout function
    function logout() {
        // Clear localStorage or sessionStorage (based on the session type you're using)
        localStorage.clear();  // Or use sessionStorage.clear() if you want to clear session storage
        alert("You have been logged out.");

        // Redirect to the login page
        window.location.href = "login.html";  // Replace "login.html" with the actual login page URL
    }
