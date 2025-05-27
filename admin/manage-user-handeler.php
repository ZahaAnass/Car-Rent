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
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$user_id = $_SESSION['user_id'];

if(!validate_user_id($user_id) || !validate_action($action)){
    $_SESSION['action_error'] = 'Invalid user ID or action.';
    redirect("manage-users.php");
}

switch($action){
    case 'add':
        $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING));
        $last_name = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING));
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));
        $role = trim(filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING));
        $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING)); 
        $license_number = trim(filter_input(INPUT_POST, 'license_number', FILTER_SANITIZE_STRING));
        $address_country = trim(filter_input(INPUT_POST, 'address_country', FILTER_SANITIZE_STRING));
        $address_city = trim(filter_input(INPUT_POST, 'address_city', FILTER_SANITIZE_STRING));
        
        if(!validate_name($first_name) || !validate_name($last_name) || !validate_email($email) || !validate_password($password) || !validate_role($role) || !validate_phone($phone) || !validate_license($license_number) || !validate_name($address_country) || !validate_name($address_city)){
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
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
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