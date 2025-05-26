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
    case 'add':
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $license_number = trim($_POST['license_number'] ?? '');
        $address_country = trim($_POST['address_country'] ?? '');
        $address_city = trim($_POST['address_city'] ?? '');
        
        if(!validate_name($first_name) || !validate_name($last_name) || !validate_email($email) || !validate_password($password) || !validate_role($role)){
            $_SESSION['action_error'] = 'Invalid user data.';
            redirect("manage-users.php");
        }
        $userQueries->createUser($first_name, $last_name, $email, $password, $role, $phone, $license_number, $address_country, $address_city);
        $_SESSION['action_success'] = 'User added successfully.';
        redirect("manage-users.php");
        break;
    case 'delete':
        $userQueries->deleteUser($user_id);
        $_SESSION['action_success'] = 'User deleted successfully.';
        redirect("manage-users.php");
        break;
    case 'update_role':
        $role = $_POST['role'] ?? '';
        if(!validate_role($role)){
            $_SESSION['action_error'] = 'Invalid role.';
            redirect("manage-users.php");
        }
        $userQueries->changeUserRole($user_id, $role);
        $_SESSION['action_success'] = 'User role updated successfully.';
        redirect("manage-users.php");
        break;
}

?>