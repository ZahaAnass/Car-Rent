<?php
require_once '../includes/session.php';
start_session();

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/queries/user_queries.php';

// Check if user is logged in
if (!is_logged_in()) {
    redirect('../auth/login.php');
}

// Initialize error variable
$error = '';

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['complete_profile'])) {
    // Sanitize inputs
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
    $license_number = trim(filter_input(INPUT_POST, 'license_number', FILTER_SANITIZE_STRING));
    $country = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
    $city = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
    
    // Validate inputs
    if (!validate_phone($phone)) {
        $error = 'Please enter a valid phone number';
    } elseif (!validate_license($license_number)) {
        $error = 'License number must be 5-15 alphanumeric characters';
    } elseif (empty($country)) {
        $error = 'Please select your country';
    } elseif (empty($city)) {
        $error = 'Please select your city';
    } else {
        try {
            // Create UserQueries instance
            $userQueries = new UserQueries($pdo);
            
            // Complete the profile
            $result = $userQueries->completeProfile(
                $_SESSION['user_id'],
                $phone,
                $license_number,
                $country,
                $city
            );
            
            if ($result === 'duplicate_license') {
                $error = 'License number is already registered by another user.';
            } elseif ($result) {
                // Profile completion successful
                $_SESSION['login_success'] = 'Profile completed successfully! Welcome to Zoomix.';
                unset($_SESSION['google_signup']); // Remove the Google signup flag
                redirect('../user/dashboard.php');
            } else {
                $error = 'Failed to complete profile. Please try again.';
            }
        } catch (Exception $e) {
            $error = 'An unexpected error occurred. Please try again.';
            error_log("Profile completion error: " . $e->getMessage());
        }
    }
    
    // If profile completion fails, store error and redirect back
    if (!empty($error)) {
        $_SESSION['profile_error'] = $error;
        redirect('../auth/complete-profile.php');
    }
} else {
    // Direct access not allowed
    redirect('../auth/complete-profile.php');
}
?>