<?php
require_once '../includes/session.php';
start_session();

require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/queries/user_queries.php';

require __DIR__ . "/../vendor/autoload.php";

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

$client = new Google\Client;
$client->setClientId($_ENV["CLIENT_ID"]);
$client->setClientSecret($_ENV["CLIENT_SECRET"]);
$client->setRedirectUri($_ENV["REDIRECT_URI"]); 

if(!isset($_GET['code'])){
    $_SESSION['login_error'] = "Google authentication failed";
    redirect('../auth/login.php');
}

try {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    if (isset($token['error'])) {
        $_SESSION['login_error'] = "Google authentication failed";
        redirect('../auth/login.php');
    }

    $client->setAccessToken($token['access_token']);
    $oauth = new Google\Service\Oauth2($client);
    $userinfo = $oauth->userinfo->get();

    // Create UserQueries instance
    $userQueries = new UserQueries($pdo);

    // Check if user exists with this email
    $existingUser = $userQueries->getUserByEmail($userinfo->email);

    if ($existingUser) {
        // User exists - log them in
        $_SESSION['user_id'] = $existingUser['user_id'];
        $_SESSION['user_email'] = $existingUser['email'];
        $_SESSION['user_role'] = $existingUser['role'];
        $_SESSION['login_success'] = "Welcome back!";
        $_SESSION['google_signup'] = true;
        $_SESSION['google_user'] = true;
        $_SESSION["user"] = $existingUser;

        // Redirect based on role
        if ($existingUser['role'] === 'Admin') {
            redirect('../admin/dashboard.php');
        } else {
            redirect('../user/dashboard.php');
        }
    } else {
        // User doesn't exist - create new account
        $firstName = $userinfo->given_name ?? '';
        $lastName = $userinfo->family_name ?? '';
        
        // Generate a random password for Google users (they won't use it)
        $randomPassword = bin2hex(random_bytes(16));
        $hashedPassword = hash_password($randomPassword);
        
        // Create user with minimal required info
        // Note: You'll need to handle missing required fields like license_number
        $userId = $userQueries->createGoogleUser(
            $firstName,
            $lastName,
            $userinfo->email,
            $hashedPassword,
            null, // phone - will need to be collected later
            null, // license - will need to be collected later
            'User', // default role
            null, // country - will need to be collected later
            null  // city - will need to be collected later
        );

        if ($userId) {
            // Set session variables
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_email'] = $userinfo->email;
            $_SESSION['user_role'] = 'User';
            $_SESSION['login_success'] = "Account created successfully! Please complete your profile.";
            $_SESSION['google_signup'] = true; // Flag to show profile completion prompt
            $_SESSION['google_user'] = true;
            $_SESSION["user"] = $existingUser;
            
            redirect('../auth/profile-completion.php');
        } else {
            $_SESSION['login_error'] = "Failed to create account. Please try again.";
            redirect('../auth/login.php');
        }
    }

} catch (Exception $e) {
    error_log("Google OAuth error: " . $e->getMessage());
    $_SESSION['login_error'] = "Authentication failed. Please try again.";
    redirect('../auth/login.php');
}
?>