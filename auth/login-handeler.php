<?php
// Include necessary files
require_once '../includes/session.php';
// Start session
start_session();
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/queries/user_queries.php';


// Initialize error variable
$error = '';

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $email = validate_email($_POST['email']) ? $_POST['email'] : "";
    $password = validate_password($_POST['password']) ? $_POST['password'] : "";
    // Check if user wants to be remembered
    $remember_me = isset($_POST['remember-me']);

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
                if (password_verify($password, $user['password_hash'])) {
                    // Successful login
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_role'] = $user['role'];

                    // Log login attempt
                    error_log("Successful login: {$email}");

                    // Remember Me: create token and set cookie
                    if ($remember_me) {
                        $token = bin2hex(random_bytes(32));
                        // Set secure, httpOnly cookie for 30 days
                        setcookie('remember_me', $token, time() + (86400 * 30), '/');
                        // Store token in DB
                        $userQueries->createRememberMeToken($user['user_id'], $token, date('Y-m-d H:i:s', time() + (86400 * 30)));
                    }

                    // Redirect based on user role
                    if ($user['role'] === 'Admin') {
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