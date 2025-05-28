<?php
require_once "../includes/session.php";
start_session();
require_once "../config/database.php";
require_once "../includes/functions.php";
require_once "../includes/queries/user_queries.php";

// Initialize error variable
$error = '';

// Create UserQueries instance
$userQueries = new UserQueries($pdo);

// Get current user ID
$current_user_id = $_SESSION['user_id'] ?? null;

// Check if user is logged in
if (!$current_user_id) {
    $_SESSION['action_error'] = 'You must be logged in to perform this action.';
    redirect("login.php");
}

$actions = ["update_role", "delete"];

// Get action from POST
$action = $_POST['action'] ?? '';

// Validate action
if (!in_array($action, $actions)) {
    $_SESSION['action_error'] = 'Invalid action specified.';
    redirect("manage-users.php");
}

// Handle different actions
switch ($action) {
    case 'update_role':
        // Validate required fields
        if (empty($_POST['user_id']) || !isset($_POST['role'])) {
            $_SESSION['action_error'] = 'Missing required fields.';
            redirect("manage-users.php");
        }

        $user_id = validate_user_id($_POST['user_id']) ?? null;
        $new_role = validate_role($_POST['role']) ?? null;

        // Validate role
        if (!in_array($new_role, ['Admin', 'User'])) {
            $_SESSION['action_error'] = 'Invalid role specified.';
            redirect("manage-users.php");
        }

        // Prevent user from modifying their own role
        if ($user_id === $current_user_id) {
            $_SESSION['action_error'] = 'You cannot change your own role.';
            redirect("manage-users.php");
        }

        // Update role
        if ($userQueries->changeUserRole($user_id, $new_role)) {
            $_SESSION['action_success'] = 'User role updated successfully.';
        } else {
            $_SESSION['action_error'] = 'Failed to update user role. Please try again.';
        }
        break;

    case 'delete':
        // Validate required fields
        if (empty($_POST['user_id'])) {
            $_SESSION['action_error'] = 'User ID is required.';
            redirect("manage-users.php");
        }

        $user_id = validate_user_id($_POST['user_id']) ?? null;

        // Prevent user from deleting themselves
        if ($user_id === $current_user_id) {
            $_SESSION['action_error'] = 'You cannot delete your own account.';
            redirect("manage-users.php");
        }

        // Delete user
        if ($userQueries->deleteUser($user_id)) {
            $_SESSION['action_success'] = 'User deleted successfully.';
        } else {
            $_SESSION['action_error'] = 'Failed to delete user. Please try again.';
        }
        break;

    default:
        $_SESSION['action_error'] = 'Invalid action specified.';
        break;
}

// Redirect back to users page
redirect("manage-users.php");