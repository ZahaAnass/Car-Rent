<?php

// Include necessary files
require_once '../config/config.php';
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';
require_once '../includes/queries/car_queries.php';

// Start session
start_session();

// Initialize error variable
$error = '';

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs first
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $type  = trim(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING));
    $price      = trim(filter_input(INPUT_POST, 'daily_rate', FILTER_SANITIZE_STRING)); 
    $image = $_FILES['car_image_file'] ?? '';
    $status    = trim(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING));
    $license   = trim(filter_input(INPUT_POST, 'license_plate', FILTER_SANITIZE_STRING));
    $year      = trim(filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT));
    $make      = trim(filter_input(INPUT_POST, 'make', FILTER_SANITIZE_STRING));
    $model     = trim(filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING));
    $color     = trim(filter_input(INPUT_POST, 'color', FILTER_SANITIZE_STRING));
    $seats     = trim(filter_input(INPUT_POST, 'seats', FILTER_SANITIZE_NUMBER_INT));
    $fuel_type = trim(filter_input(INPUT_POST, 'fuel_type', FILTER_SANITIZE_STRING));
    $features  = trim(filter_input(INPUT_POST, 'features', FILTER_SANITIZE_STRING));
    
    // Validate inputs
    if (!validate_name($name)) {
        $error = 'Name must be at least 2 characters';
    } elseif (!validate_name($type)) {
        $error = 'Type must be at least 2 characters';
    } elseif (!validate_price($price)) {
        $error = 'Please enter a valid price';
    } elseif (!validate_license_plate($license)) {
        $error = 'License plate must be at least 2 characters';
    } elseif (!validate_status($status)) {
        $error = 'Please select your status';
    } elseif (!validate_year($year)) {
        $error = 'Please select your year';
    } elseif (!validate_name($make)) {
        $error = 'Please select your make';
    } elseif (!validate_name($model)) {
        $error = 'Please select your model';
    } elseif (!validate_name($color)) {
        $error = 'Please select your color';
    } elseif (!validate_seats($seats)) {
        $error = 'Please select your seats';
    } elseif (!validate_fuel_type($fuel_type)) {
        $error = 'Please select your fuel type';
    } elseif (!validate_features($features)) {
        $error = 'Please select your features';
    } else {
        try {
            // Create UserQueries instance
            $carQueries = new CarQueries($pdo);
            
            // Check if license number already exists
            if ($carQueries->licenseExists($license)) {
                $error = 'License number is already registered';
                error_log("Registration attempt with existing license: {$license}");
            }
            else {
                // Create new car
                $result = $carQueries->createCar(
                    $name,
                    $type,
                    $price,
                    $image,
                    $status,
                    $license,
                    $year,
                    $make,
                    $model,
                    $color,
                    $seats,
                    $fuel_type,
                    $features
                );
                
                if ($result === 'duplicate_license') {
                    $error = 'License number is already registered.';
                    error_log("Registration failed due to duplicate license: {$license}");
                }
                elseif ($result) { 
                    // Registration successful
                    $_SESSION['register_success'] = 'Registration successful! Please log in.';
                    error_log("Successful registration: {$license}");
                    redirect('../admin/manage-cars.php');
                } else {
                    // Registration failed
                    $error = 'Registration failed. Please try again.';
                    error_log("Registration failed for: {$license}");
                }
            }
        } catch (Exception $e) {
            // Handle any unexpected errors
            $error = 'An unexpected error occurred. Please try again.';
            error_log("Registration error: " . $e->getMessage());
        }
        }
    
    // If registration fails, store error in session and redirect back to register
    if (!empty($error)) {
        $_SESSION['register_error'] = $error;
        redirect('../auth/register.php');
    }
}
?>