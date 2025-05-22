<?php
require_once '../includes/session.php';
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/queries/user_queries.php';

// Clear Remember Me Cookie and Database Token
if (isset($_COOKIE['remember_me'])) {
    $token = $_COOKIE['remember_me'];

    // Delete token from the database
    try {
        $stmt = $pdo->prepare("DELETE FROM remember_me_tokens WHERE token = :token");
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error deleting remember_me token: " . $e->getMessage());
    }

    // Unset the cookie
    setcookie('remember_me', '', time() - 3600, '/');
    
    // Remove it from the $_COOKIE superglobal for the current script execution
    unset($_COOKIE['remember_me']);
}

logout_user();
?>