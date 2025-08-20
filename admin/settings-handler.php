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
    redirect("../auth/login.php");
}

// Process form submission
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize inputs
        if (isset($_POST['action'])) {
            $action = $_POST['action'];

            switch ($action) {
                case 'update_profile':
                    $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                    $phone_number = trim(filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $current_email = trim(filter_input(INPUT_POST, 'current_email', FILTER_SANITIZE_EMAIL));

                    if (validate_name($first_name) && validate_name($last_name) && validate_email($email) && validate_phone($phone_number) && validate_email($current_email)) {

                        if ($email !== $current_email) {
                            if ($userQueries->emailExists($email)) {
                                $_SESSION['error'] = "This email is already registered";
                                redirect("settings.php");
                            }
                        }

                        if ($userQueries->updateUserProfile($_SESSION['user_id'], $first_name, $last_name, $email, $phone_number)) {
                            $_SESSION['success'] = "Profile updated successfully!";
                            $_SESSION['user_name'] = $first_name . ' ' . $last_name;
                            $_SESSION['user_email'] = $email;
                            $_SESSION["user"] = $userQueries->getUserById($_SESSION['user_id']);
                            redirect("settings.php");
                        } else {
                            $_SESSION['error'] = "Failed to update profile. Please try again.";
                            redirect("settings.php");
                        }

                    } else {
                        $_SESSION['error'] = "Invalid input";
                        redirect("settings.php");
                    }

                    break;

                case 'change_password':
                    $current_password = trim(filter_input(INPUT_POST, 'current_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $new_password = trim(filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
                    $confirm_password = trim(filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

                    if (validate_password($current_password) && validate_password($new_password) && validate_password($confirm_password)) {
                        if (!$userQueries->validateCurrentPassword($_SESSION['user_id'], $current_password)) {
                            $_SESSION['error'] = "Current password is incorrect";
                            redirect("settings.php");
                        }
                        if (!validate_confirm_password($new_password, $confirm_password)) {
                            $_SESSION['error'] = "New password and confirm password do not match";
                            redirect("settings.php");
                        }

                        if ($userQueries->changePassword($_SESSION['user_id'], $new_password)) {
                            $_SESSION['success'] = "Password changed successfully!";
                            $_SESSION['user'] = $userQueries->getUserById($_SESSION['user_id']);
                            redirect("settings.php");
                        } else {
                            $_SESSION['error'] = "Failed to change password. Please try again.";
                            redirect("settings.php");
                        }
                    } else {
                        $_SESSION['error'] = "Invalid input";
                        redirect("settings.php");
                    }
                    break;

                case 'delete_account':
                    if (isset($_POST['delete_confirm']) && $_POST['delete_confirm'] === 'DELETE') {
                        if ($userQueries->deleteUser($_SESSION['user_id'])) {
                            $_SESSION['success'] = "Account deleted successfully!";
                            session_destroy();
                            redirect("../auth/login.php");
                        } else {
                            $_SESSION['error'] = "Failed to delete account. Please try again.";
                            redirect("settings.php");
                        }
                    } else {
                        $_SESSION['error'] = "Invalid input";
                        redirect("settings.php");
                    }
                    break;

                default:
                    $_SESSION['error'] = "Invalid action";
                    redirect("settings.php");
                    break;
            }
        } else {
            $_SESSION['error'] = "Invalid action";
            redirect("settings.php");
        }
    }
} catch (Exception $e) {
    $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    redirect("settings.php");
}

?>
