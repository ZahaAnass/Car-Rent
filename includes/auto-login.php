<?php
require_once '../includes/functions.php';
require_once '../includes/session.php';
start_session();

require_once '../config/database.php'; 
require_once '../includes/queries/user_queries.php'; 

if (!is_logged_in() && isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];
    if (isset($pdo)) {
        $userQueries = new UserQueries($pdo);
        $user_id = $userQueries->getUserFromRememberMeToken($token); 

        if ($user_id) { 
            $user = $userQueries->getUserById($user_id); 

            if ($user) {
                if (isset($user['user_id'], $user['email'])) {
                    login_user(
                        $user['user_id'],
                        $user['email'],
                        $user['first_name'],
                        $user['last_name'],
                        $user['role']
                    );

                    // Token Rotation using UserQueries class methods
                    // 1. Delete the old token
                    $userQueries->deleteRememberMeToken($token); 
                    // 2. Generate a new token
                    $new_token = bin2hex(random_bytes(32));
                    // 3. Store new token in DB
                    $userQueries->createRememberMeToken($user['user_id'], $new_token, date('Y-m-d H:i:s', time() + (86400 * 30)));
                    // 4. Set new cookie 
                    setcookie('remember_me', $new_token, time() + (86400 * 30), '/'); 
                    redirect(basename($_SERVER['PHP_SELF'])); 
                } else {
                    error_log('Auto-login failed: Missing essential user_id or email for user ID: ' . $user_id . ' from token: ' . $token);
                    $userQueries->deleteRememberMeToken($token); 
                }
            } else {
                // User ID from token didn't correspond to an existing user
                error_log('Auto-login failed: User not found for user_id: ' . $user_id . ' from token: ' . $token);
                $userQueries->deleteRememberMeToken($token); 
            }
        } 
    } else {
        echo "PDO object not available for auto-login in header.php";
        error_log("PDO object not available for auto-login in header.php");
    }
}
?>