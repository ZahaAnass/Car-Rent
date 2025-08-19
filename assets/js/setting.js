// Enable/disable delete button based on confirmation
const deleteConfirm = document.getElementById('deleteConfirm');
const confirmCheck = document.getElementById('confirmCheck');
const deleteAccountBtn = document.getElementById('deleteAccountBtn');

function updateDeleteButtonState() {
    const isConfirmed = deleteConfirm.value.trim().toUpperCase() === 'DELETE' && confirmCheck.checked;
    deleteAccountBtn.disabled = !isConfirmed;
}

deleteConfirm.addEventListener('input', updateDeleteButtonState);
confirmCheck.addEventListener('change', updateDeleteButtonState);

function confirmDeleteAccount() {
    return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone!');
}