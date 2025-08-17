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
                
                break;
            case "delete":
                
                break;
            case "add":
                
                break;
            default:
                $_SESSION['action_error'] = 'Invalid action specified.';
                break;
        }
    }
}