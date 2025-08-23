<?php
require_once '../includes/session.php';
start_session();

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/queries/user_queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verify_code'])) {
    $code = trim($_POST['code']);
    $email = $_SESSION['reset_email'] ?? '';
    
    if (empty($email)) {
        redirect('../auth/forgot-password.php');
    }
    
    if (!preg_match('/^[0-9]{6}$/', $code)) {
        $_SESSION['verify_error'] = 'Please enter a valid 6-digit code.';
        redirect('../auth/verify-code.php');
    }
    
    try {
        $userQueries = new UserQueries($pdo);
        $user = $userQueries->getUserByEmail($email);
        
        if (!$user) {
            $_SESSION['verify_error'] = 'Invalid session. Please start again.';
            unset($_SESSION['reset_email']);
            redirect('../auth/forgot-password.php');
        }
        
        $resetData = $userQueries->verifyCode($user['user_id'], $code);
        
        if ($resetData) {
            $userQueries->markCodeAsUsed($resetData['token']);
            $_SESSION['reset_token'] = $resetData['token'];
            redirect('../auth/reset-password.php');
        } else {
            $_SESSION['verify_error'] = 'Invalid or expired verification code.';
            redirect('../auth/verify-code.php');
        }
        
    } catch (Exception $e) {
        error_log("Code verification error: " . $e->getMessage());
        $_SESSION['verify_error'] = 'An error occurred. Please try again later.';
        redirect('../auth/verify-code.php');
    }
} else {
    redirect('../auth/verify-code.php');
}