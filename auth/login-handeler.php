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
    // Sanitize and validate input
    $email = validate_email($_POST['email']) ? $_POST['email'] : "";
    $password = validate_password($_POST['password']) ? $_POST['password'] : "";
    // $remember_me = isset($_POST['remember-me']) ? true : false;

    // Validate email format
    if ($email === "" || $password === "") {
        $error = 'Invalid email or password';
    } else {
        try {
            // Create UserQueries instance
            $userQueries = new UserQueries($pdo);

            // Attempt to authenticate user
            $user = $userQueries->getUserByEmail($email);

            if ($user) {
                // Verify password
                if (password_verify($password, $user['password'])) {
                    // Successful login
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];

                    // Log login attempt
                    error_log("Successful login: {$email}");

                    // Redirect based on user role
                    if ($user['role'] === 'admin') {
                        redirect('../admin/dashboard.php');
                    } else {
                        redirect('../user/dashboard.php');
                    }
                } else {
                    // Failed login - incorrect password
                    $error = 'Invalid email or password';
                    error_log("Failed login attempt (incorrect password): {$email}");
                }
            } else {
                // User not found
                $error = 'Invalid email or password';
                error_log("Failed login attempt (user not found): {$email}");
            }
        } catch (Exception $e) {
            // Handle any unexpected errors
            $error = 'An unexpected error occurred. Please try again.';
            error_log("Login error: " . $e->getMessage());
            echo "Login error: " . $e->getMessage();
        }
    }

    // If login fails, store error in session and redirect back to login
    if (!empty($error)) {
        $_SESSION['login_error'] = $error;
        redirect('../auth/login.php');
    }
} else {
    // Direct access to handler is not allowed
    redirect('../auth/login.php');
}