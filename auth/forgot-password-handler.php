<?php
require_once '../includes/session.php';
start_session();

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/queries/user_queries.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['forgot_password'])) {
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    
    if (!validate_email($email)) {
        $_SESSION['forgot_error'] = 'Please enter a valid email address.';
        redirect('../auth/forgot-password.php');
    }
    
    try {
        $userQueries = new UserQueries($pdo);
        $user = $userQueries->getUserByEmail($email);
        
        if ($user) {
            // Generate 6-digit verification code
            $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            $token = bin2hex(random_bytes(32)); // Still keep token for security
            $expires = date('Y-m-d H:i:s', time() + (15 * 60)); // 15 minutes expiry
            
            // Delete any existing reset codes for this user
            $userQueries->deleteResetCodes($user['user_id']);
            
            // Store code in database
            $userQueries->storeResetCode($user['user_id'], $code, $token, $expires);
            
            // Send verification code email
            if (sendVerificationCodeEmail($email, $user['first_name'], $code)) {
                $_SESSION['reset_email'] = $email; // Store email for next step
                redirect('../auth/verify-code.php'); // Redirect to code verification
            } else {
                $_SESSION['forgot_error'] = 'Failed to send verification email. Please try again later.';
                redirect('../auth/forgot-password.php');
            }
        } else {
            // Email doesn't exist
            $_SESSION['forgot_error'] = 'Email not found. Please try again.';
            redirect('../auth/forgot-password.php');
        }
        
    } catch (Exception $e) {
        echo "Forgot password error: " . $e->getMessage();
        $_SESSION['forgot_error'] = 'An error occurred. Please try again later.';
        redirect('../auth/forgot-password.php');
    }
} else {
    redirect('../auth/forgot-password.php');
}

