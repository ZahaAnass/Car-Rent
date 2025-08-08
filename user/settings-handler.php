<?php

require_once "../includes/session.php";
start_session();
require_once "../config/database.php";
require_once "../includes/functions.php";
require_once "../includes/queries/user_queries.php";

// Initialize database connection and user queries
$userQueries = new UserQueries($pdo);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Please log in first.";
    redirect("../login.php");
    exit();
}

echo "<pre>";
print_r($_POST);
print_r($_SESSION);
echo "</pre>";

// Process form submission
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $phone_number = trim(filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $current_email = trim(filter_input(INPUT_POST, 'current_email', FILTER_SANITIZE_EMAIL));

    // Validate inputs
    if (empty($first_name) || empty($last_name) || empty($email)) {
        $_SESSION['error'] = 'Please fill in all required fields';
        redirect("settings.php");
    }

    // Check if email is already in use by another user
    if ($email !== $current_email) {
        if ($userQueries->emailExists($email)) {
            $_SESSION['error'] = 'This email is already registered';
            redirect("settings.php");
        }
    }

    // Update user
    if ($userQueries->updateUserProfile($_SESSION['user_id'], $first_name, $last_name, $email, $phone_number)) {
        $_SESSION['success'] = "Profile updated successfully!";
        $_SESSION['user_name'] = $first_name . ' ' . $last_name; // Update session name
        $_SESSION['user_email'] = $email; // Update session email
    } else {
        $_SESSION['error'] = "Failed to update profile. Please try again.";
    }
    
    redirect("settings.php");
}    
} catch (Exception $e) {
    $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    redirect("settings.php");
}

?>