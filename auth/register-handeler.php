<?php
// Include necessary files
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';
require_once '../includes/queries/user_queries.php';

// Start session
start_session();

// Initialize error variable
$error = '';

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs first
    $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING));
    $last_name  = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING));
    $email      = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $phone      = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING)); 
    $license_number = trim(filter_input(INPUT_POST, 'license_number', FILTER_SANITIZE_STRING));
    $country    = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
    $city       = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
    $password   = $_POST['password'] ?? ''; 
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate inputs
    if (!validate_name($first_name)) {
        $error = 'First name must be at least 2 characters';
    } elseif (!validate_name($last_name)) {
        $error = 'Last name must be at least 2 characters';
    } elseif (!validate_email($email)) {
        $error = 'Please enter a valid email address';
    } elseif (!validate_phone($phone)) {
        $error = 'Please enter a valid phone number';
    } elseif (!validate_license($license_number)) {
        $error = 'License number must be 5-15 alphanumeric characters';
    } elseif (empty($country)) {
        $error = 'Please select your country';
    } elseif (empty($city)) {
        $error = 'Please select your city';
    } elseif (!validate_password($password)) {
        $error = 'Password must be at least 8 characters with uppercase, lowercase, and number';
    } elseif (!validate_confirm_password($password, $confirm_password)) {
        $error = 'Passwords do not match';
    } else {
        try {
            // Create UserQueries instance
            $userQueries = new UserQueries($pdo);
            
            // Check if email already exists
            if ($userQueries->emailExists($email)) {
                $error = 'Email address is already registered';
                error_log("Registration attempt with existing email: {$email}");
            } 
            // Check if license number already exists
            elseif ($userQueries->licenseExists($license_number)) {
                $error = 'License number is already registered';
                error_log("Registration attempt with existing license: {$license_number}");
            }
            else {
                // Hash the password
                $hashed_password = hash_password($password);
                
                // Create new user
                $result = $userQueries->createUser(
                    $first_name,
                    $last_name,
                    $email,
                    $hashed_password,
                    $phone,
                    $license_number,
                    'User', // Role
                    $country,
                    $city
                );
                
                if ($result === 'duplicate_license') {
                    $error = 'License number is already registered.';
                    error_log("Registration failed due to duplicate license: {$license_number}");
                }
                elseif ($result) { 
                    // Registration successful
                    $_SESSION['register_success'] = 'Registration successful! Please log in.';
                    error_log("Successful registration: {$email}");
                    redirect('../auth/login.php');
                } else {
                    // Registration failed
                    $error = 'Registration failed. Please try again.';
                    error_log("Registration failed for: {$email}");
                }
            }
        } catch (Exception $e) {
            // Handle any unexpected errors
            $error = 'An unexpected error occurred. Please try again.';
            error_log("Registration error: " . $e->getMessage());
        }
    }
    
    // If registration fails, store error in session and redirect back to register
    if (!empty($error)) {
        $_SESSION['register_error'] = $error;
        redirect('../auth/register.php');
    }
} else {
    // Direct access to handler is not allowed
    redirect('../auth/register.php');
}