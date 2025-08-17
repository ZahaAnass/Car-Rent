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
                    // Sanitize inputs first
                    $first_name = trim(filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING));
                    $last_name  = trim(filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING));
                    $email      = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                    $phone      = trim(filter_input(INPUT_POST, 'phone_number', FILTER_SANITIZE_STRING));
                    $license_number = trim(filter_input(INPUT_POST, 'license_number', FILTER_SANITIZE_STRING));
                    $country    = trim(filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING));
                    $city       = trim(filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING));
                    $role       = trim(filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING));
                    $password   = $_POST['password'] ?? ''; 
                    $confirm_password = $_POST['confirm_password'] ?? '';
                    
                    // Validate inputs
                    if (!validate_name($first_name)) {
                        $error = 'First name must be at least 2 characters';
                    } elseif (!validate_name($last_name)) {
                        $error = 'Last name must be at least 2 characters';
                    } elseif (!validate_email($email)) {
                        $error = 'Please enter a valid email address';
                    } elseif (!validate_phone($phone)) {
                        $error = 'Please enter a valid phone number';
                    } elseif (!validate_license($license_number)) {
                        $error = 'License number must be 5-15 alphanumeric characters';
                    } elseif (empty($country)) {
                        $error = 'Please select your country';
                    } elseif (empty($city)) {
                        $error = 'Please select your city';
                    } elseif (!in_array($role, ['Admin', 'User'])) {
                        $error = 'Invalid role specified. Must be Admin or User.';
                    } elseif (!validate_password($password)) {
                        $error = 'Password must be at least 8 characters with uppercase, lowercase, and number';
                    } elseif (!validate_confirm_password($password, $confirm_password)) {
                        $error = 'Passwords do not match';
                    } else {
                        try {
                            if ($userQueries->emailExists($email)) {
                                $error = 'Email address is already registered';
                                error_log("Add user attempt with existing email: {$email}");
                            } 
                            elseif ($userQueries->licenseExists($license_number)) {
                                $error = 'License number is already registered';
                                error_log("Add user attempt with existing license: {$license_number}");
                            }
                            else {
                                $hashed_password = hash_password($password);
                                $result = $userQueries->createUser(
                                    $first_name,
                                    $last_name,
                                    $email,
                                    $hashed_password,
                                    $phone,
                                    $license_number,
                                    $role, 
                                    $country,
                                    $city
                                );
                                
                                if ($result === 'duplicate_license') {
                                    $error = 'License number is already registered.';
                                    error_log("Add user failed due to duplicate license: {$license_number}");
                                }
                                elseif ($result) { 
                                    $_SESSION['action_success'] = 'User created successfully!';
                                    error_log("Successful user creation by admin: {$email}");
                                    redirect("manage-users.php");
                                } else {
                                    
                                    $error = 'User creation failed. Please try again.';
                                    error_log("User creation failed for: {$email}");
                                }
                            }
                        } catch (Exception $e) {
                            $error = 'An unexpected error occurred. Please try again.';
                            error_log("User creation error: " . $e->getMessage());
                        }
                    }
                    
                    // If user creation fails, store error in session and redirect back
                    if (!empty($error)) {
                        $_SESSION['action_error'] = $error;
                        redirect("manage-users.php");
                    }
                    break;

            default:
                $_SESSION['action_error'] = 'Invalid action specified.';
                redirect("manage-users.php");
                break;
        }
    }
}
?>