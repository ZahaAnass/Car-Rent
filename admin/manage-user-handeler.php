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

$actions = ["update_role", "delete", "add"];

// Get action from GET
$action = $_GET['action'] ?? '';

// Validate action
if (!in_array($action, $actions)) {
    $_SESSION['action_error'] = 'Invalid action specified.';
    redirect("manage-users.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($action)){
        switch($action){
            case "update_role":
                if (!isset($_POST['userId']) || !isset($_POST['role'])) {
                    $_SESSION['action_error'] = 'Missing required data.';
                    redirect("manage-users.php");
                }

                $user_id = validate_user_id($_POST['userId']);
                $new_role = validate_role($_POST['role']);

                if ($user_id === false || $user_id === null) {
                    $_SESSION['action_error'] = 'Invalid user ID specified.';
                    redirect("manage-users.php");
                }

                if ($new_role === false || $new_role === null) {
                    $_SESSION['action_error'] = 'Invalid role specified.';
                    redirect("manage-users.php");
                }

                $user_id = $_POST['userId'];
                $new_role = $_POST['role'];

                if (!in_array($new_role, ['Admin', 'User'])) {
                    $_SESSION['action_error'] = 'Invalid role specified. Must be Admin or User.';
                    redirect("manage-users.php");
                }

                if ((int)$user_id === (int)$current_user_id) {
                    $_SESSION['action_error'] = 'You cannot change your own role.';
                    redirect("manage-users.php");
                }
                $targetUser = $userQueries->getUserById($user_id);
                if (!$targetUser) {
                    $_SESSION['action_error'] = 'User not found.';
                    redirect("manage-users.php");
                }

                if ($userQueries->changeUserRole($user_id, $new_role)) {
                    $_SESSION['action_success'] = "User role updated successfully to {$new_role}.";
                } else {
                    $_SESSION['action_error'] = 'Failed to update user role. Please try again.';
                }
                redirect("manage-users.php");
                break;

            case "delete":
                if (!isset($_POST['userId'])) {
                    $_SESSION['action_error'] = 'Missing required data.';
                    redirect("manage-users.php");
                }
                $user_id = validate_user_id($_POST['userId']);
                if ($user_id === false || $user_id === null) {
                    $_SESSION['action_error'] = 'Invalid user ID specified.';
                    redirect("manage-users.php");
                }

                $user_id = $_POST['userId'];
                if ((int)$user_id === (int)$current_user_id) {
                    $_SESSION['action_error'] = 'You cannot delete your own account.';
                    $_SESSION['action_error'] = "user_id = {$user_id} current_user_id = {$current_user_id}";
                    redirect("manage-users.php");
                }
                $targetUser = $userQueries->getUserById($user_id);
                if (!$targetUser) {
                    $_SESSION['action_error'] = 'User not found.';
                    redirect("manage-users.php");
                }
                if ($userQueries->deleteUser($user_id)) {
                    $_SESSION['action_success'] = "User deleted successfully.";
                } else {
                    $_SESSION['action_error'] = 'Failed to delete user. Please try again.';
                }
                redirect("manage-users.php");
                break;

            case "add":
                // TODO: Add user creation logic here
                break;

            default:
                $_SESSION['action_error'] = 'Invalid action specified.';
                redirect("manage-users.php");
                break;
        }
    }
}
?>