<?php
require_once '../includes/session.php';
start_session();

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/queries/user_queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_password'])) {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate inputs
    if (empty($token)) {
        $_SESSION['reset_error'] = 'Invalid reset token.';
        redirect('../auth/forgot-password.php');
    }
    
    if (!validate_password($password)) {
        $_SESSION['reset_error'] = 'Password must be at least 8 characters with uppercase, lowercase, and number.';
        redirect('../auth/reset-password.php');
    }
    
    if (!validate_confirm_password($password, $confirm_password)) {
        $_SESSION['reset_error'] = 'Passwords do not match.';
        redirect('../auth/reset-password.php');
    }
    
    try {
        $userQueries = new UserQueries($pdo);
        $user = $userQueries->verifyToken($token);
        
        if (!$user) {
            $_SESSION['reset_error'] = 'Invalid or expired reset session.';
            unset($_SESSION['reset_token'], $_SESSION['reset_email']);
            redirect('../auth/forgot-password.php');
        }

        $result = $userQueries->updatePassword($user['user_id'], $password);
        
        if ($result) {
            // Delete all reset tokens for this user
            $userQueries->deleteResetTokens($user['user_id']);
            
            // Delete all remember me tokens for security
            $userQueries->deleteRememberMeTokens($user['user_id']);
            
            // Clear session variables
            unset($_SESSION['reset_token'], $_SESSION['reset_email']);
            
            $_SESSION['login_success'] = 'Password has been reset successfully! Please login with your new password.';
            redirect('../auth/login.php');
        } else {
            $_SESSION['reset_error'] = 'Failed to update password. Please try again.';
            redirect('../auth/reset-password.php');
        }
        
    } catch (Exception $e) {
        error_log("Password reset error: " . $e->getMessage());
        $_SESSION['reset_error'] = 'An error occurred. Please try again later.';
        redirect('../auth/reset-password.php');
    }
} else {
    redirect('../auth/forgot-password.php');
}