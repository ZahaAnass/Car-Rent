document.addEventListener('DOMContentLoaded', function () {
    const registerForm = document.querySelector('.register-form');
    const firstNameInput = document.querySelector('input[name="first_name"]');
    const lastNameInput = document.querySelector('input[name="last_name"]');
    const emailInput = document.querySelector('input[name="email"]');
    const phoneInput = document.querySelector('input[name="phone"]');
    const licenseInput = document.querySelector('input[name="license_number"]');
    const countrySelect = document.getElementById('country');
    const citySelect = document.getElementById('city');
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmPasswordInput = document.querySelector('input[name="confirm_password"]');
    const termsCheckbox = document.getElementById('terms-agree');

    // Simplified validation on submit
    registerForm.addEventListener('submit', function (event) {
        let isValid = true;

        // --- Validation Checks ---

        // First Name
        if (firstNameInput.value.trim().length < 2) {
            firstNameInput.setCustomValidity('First name must be at least 2 characters.');
            isValid = false;
        } else {
            firstNameInput.setCustomValidity('');
        }

        // Last Name
        if (lastNameInput.value.trim().length < 2) {
            lastNameInput.setCustomValidity('Last name must be at least 2 characters.');
            isValid = false;
        } else {
            lastNameInput.setCustomValidity('');
        }

        // Email
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(emailInput.value)) {
            emailInput.setCustomValidity('Please enter a valid email address.');
            isValid = false;
        } else {
            emailInput.setCustomValidity('');
        }

        // Phone Number
        const phoneRegex = /^\+?[0-9]{10,15}$/;
        if (!phoneRegex.test(phoneInput.value)) {
            phoneInput.setCustomValidity('Please enter a valid phone number (e.g., 10-15 digits).');
            isValid = false;
        } else {
            phoneInput.setCustomValidity('');
        }
        
        // License Number
        const licenseRegex = /^[a-zA-Z0-9]{5,15}$/;
        if (!licenseRegex.test(licenseInput.value)) {
            licenseInput.setCustomValidity('License number must be 5-15 alphanumeric characters.');
            isValid = false;
        } else {
            licenseInput.setCustomValidity('');
        }

        // Country
        if (countrySelect.value === "") {
            countrySelect.setCustomValidity('Please select your country.');
            isValid = false;
        } else {
            countrySelect.setCustomValidity('');
        }

        // City
        if (citySelect.value === "") {
            citySelect.setCustomValidity('Please select your city.');
            isValid = false;
        } else {
            citySelect.setCustomValidity('');
        }

        // Password
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        if (!passwordRegex.test(passwordInput.value)) {
            passwordInput.setCustomValidity('Password must be at least 8 characters, including uppercase, lowercase, and a number.');
            isValid = false;
        } else {
            passwordInput.setCustomValidity('');
        }

        // Confirm Password
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity('Passwords do not match.');
            isValid = false;
        } else if (confirmPasswordInput.value === "") {
            confirmPasswordInput.setCustomValidity('Please confirm your password.');
            isValid = false;
        }
        else {
            confirmPasswordInput.setCustomValidity('');
        }

        // Terms and Conditions
        if (!termsCheckbox.checked) {
            termsCheckbox.setCustomValidity('You must agree to the terms and conditions.');
            isValid = false;
        } else {
            termsCheckbox.setCustomValidity('');
        }

        // If any validation failed, prevent submission
        if (!isValid) {
            event.preventDefault();
            registerForm.reportValidity();
        }
    });

    // Clear custom validity on input for a better user experience
    const allInputs = registerForm.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.addEventListener('input', () => {
            input.setCustomValidity('');
        });
        if (input.tagName === 'SELECT') {
            input.addEventListener('change', () => {
                input.setCustomValidity('');
            });
        }
    });
});