document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addUserForm');
    if (!form) return;

    const firstNameInput = form.querySelector('input[name="first_name"]');
    const lastNameInput = form.querySelector('input[name="last_name"]');
    const emailInput = form.querySelector('input[name="email"]');
    const phoneInput = form.querySelector('input[name="phone_number"]');
    const passwordInput = form.querySelector('input[name="password"]');
    const confirmPasswordInput = form.querySelector('input[name="confirm_password"]');

    form.addEventListener('submit', function (event) {
        let isValid = true;

    if (firstNameInput.value.trim().length < 2) {
        firstNameInput.setCustomValidity('First name must be at least 2 characters.');
        isValid = false;
    } else {
        firstNameInput.setCustomValidity('');
    }

    if (lastNameInput.value.trim().length < 2) {
        lastNameInput.setCustomValidity('Last name must be at least 2 characters.');
        isValid = false;
    } else {
        lastNameInput.setCustomValidity('');
    }

    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailRegex.test(emailInput.value)) {
        emailInput.setCustomValidity('Please enter a valid email address.');
        isValid = false;
    } else {
        emailInput.setCustomValidity('');
    }

    if (phoneInput.value) {
        const phoneRegex = /^[0-9]{9}$/;
        if (!phoneRegex.test(phoneInput.value)) {
            phoneInput.setCustomValidity('Please enter a valid 9-digit phone number.');
            isValid = false;
        } else {
            phoneInput.setCustomValidity('');
        }
    }

    if (passwordInput.value.length < 8) {
        passwordInput.setCustomValidity('Password must be at least 8 characters long.');
        isValid = false;
    } else {
        passwordInput.setCustomValidity('');
    }

    if (passwordInput.value !== confirmPasswordInput.value) {
        confirmPasswordInput.setCustomValidity('Passwords do not match.');
        isValid = false;
    } else if (confirmPasswordInput.value === '') {
        confirmPasswordInput.setCustomValidity('Please confirm your password.');
        isValid = false;
    } else {
        confirmPasswordInput.setCustomValidity('');
    }

    if (!isValid) {
        event.preventDefault();
        form.reportValidity();
    }
});

const inputs = form.querySelectorAll('input');
inputs.forEach(input => {
    input.addEventListener('input', () => {
        input.setCustomValidity('');
    });
});
});