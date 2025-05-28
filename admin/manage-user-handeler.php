<?php
// Include necessary files
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';
require_once '../includes/queries/user_queries.php';

// Start session
start_session();
require_once "../config/database.php";
require_once "../includes/functions.php";
require_once "../includes/queries/user_queries.php";

// Initialize error variable
$error = '';

$userQueries = new UserQueries($pdo);

// Handle Action
$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

if(!validate_user_id($user_id)){
    $_SESSION['action_error'] = 'Invalid user ID';
    redirect("manage-users.php");
}

switch($action){
    case 'update_role':
        $role = $_POST['role'] ?? '';
        if(!validate_role($role)){
            $_SESSION['action_error'] = 'Invalid role';
            redirect("manage-users.php");
        }
        $userQueries->changeUserRole($user_id, $role);
        $_SESSION['action_success'] = 'User role updated successfully.';
        redirect("manage-users.php");
        break;
    case 'delete':
        $userQueries->deleteUser($user_id);
        $_SESSION['action_success'] = 'User deleted successfully.';
        redirect("manage-users.php");
        break;
}

redirect("manage-users.php");
$_SESSION['action_error'] = 'Invalid action';

?>