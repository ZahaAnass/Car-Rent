<?php

require_once "../includes/session.php";
start_session();
require_once "../config/database.php";
require_once "../includes/functions.php";
require_once "../includes/queries/user_queries.php";

// Initialize error variable
$error = '';

$userQueries = new UserQueries($pdo);

// Handle Action
$action = $_GET['action'] ?? '';
$user_id = $_GET['user_id'] ?? '';

if(!validate_user_id($user_id) || !validate_action($action)){
    $_SESSION['action_error'] = 'Invalid user ID or action.';
    redirect("manage-users.php");
}

switch($action){
    case 'delete':
        $userQueries->deleteUser($user_id);
        $_SESSION['action_success'] = 'User deleted successfully.';
        redirect("manage-users.php");
        break;
    case 'update_role':
        $role = $_GET['role'] ?? '';
        if(!validate_role($role)){
            $_SESSION['action_error'] = 'Invalid role.';
            redirect("manage-users.php");
        }
        $userQueries->updateUserRole($user_id, $role);
        $_SESSION['action_success'] = 'User role updated successfully.';
        redirect("manage-users.php");
        break;
}


?>