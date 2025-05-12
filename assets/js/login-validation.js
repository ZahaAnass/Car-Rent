document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector(".login-form");
    const emailInput = document.querySelector("input[name='email']");
    const passwordInput = document.querySelector("input[name='password']");
    const togglePassword = document.querySelector('.toggle-password');

    // Enhanced Email Validation
    function validateEmail(email) {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email);
    }

    // Enhanced Password Validation
    function validatePassword(password) {
        // At least 8 characters, one uppercase, one lowercase, one number
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        return passwordRegex.test(password);
    }

    // Real-time validation
    emailInput.addEventListener('input', function() {
        if (!validateEmail(this.value)) {
            this.setCustomValidity("Please enter a valid email address");
        } else {
            this.setCustomValidity("");
        }
    });

    passwordInput.addEventListener('input', function() {
        if (!validatePassword(this.value)) {
            this.setCustomValidity("Password must be at least 8 characters, include uppercase, lowercase, and number");
        } else {
            this.setCustomValidity("");
        }
    });

    // Form submission validation
    loginForm.addEventListener("submit", function(e) {
        // Reset custom validities
        emailInput.setCustomValidity("");
        passwordInput.setCustomValidity("");

        // Validate email
        if (!validateEmail(emailInput.value)) {
            e.preventDefault();
            emailInput.setCustomValidity("Please enter a valid email address");
            emailInput.reportValidity();
            return false;
        }

        // Validate password
        if (!validatePassword(passwordInput.value)) {
            e.preventDefault();
            passwordInput.setCustomValidity("Password must be at least 8 characters, include uppercase, lowercase, and number");
            passwordInput.reportValidity();
            return false;
        }

        return true;
    });

});