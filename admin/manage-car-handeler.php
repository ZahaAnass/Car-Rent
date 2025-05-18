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

    // Sanitize inputs - replace deprecated FILTER_SANITIZE_STRING with FILTER_SANITIZE_FULL_SPECIAL_CHARS
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $type = trim(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $price = trim(filter_input(INPUT_POST, 'daily_rate', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
    $image = isset($_FILES['car_image_file']) ? $_FILES['car_image_file'] : '';
    $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $status = trim(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $license = trim(filter_input(INPUT_POST, 'license_plate', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $year = trim(filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT));
    $make = trim(filter_input(INPUT_POST, 'make', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $model = trim(filter_input(INPUT_POST, 'model', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $color = trim(filter_input(INPUT_POST, 'color', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $seats = trim(filter_input(INPUT_POST, 'seats', FILTER_SANITIZE_NUMBER_INT));
    $fuel_type = trim(filter_input(INPUT_POST, 'fuel_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $features = trim(filter_input(INPUT_POST, 'features', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    
    $image_path = '../assets/img/default-car.webp'; // Default image path
    
    // Handle car image upload
    if (!empty($image['name'])) {
        $file_name = $image['name'];
        $file_type = $image['type'];
        $file_size = $image['size'];
        $file_error = $image['error'];
        $file_tmp_name = $image['tmp_name'];

        // Fix: Create a temporary array and store the parts, then get the last element
        $file_parts = explode('.', $file_name);
        $file_ext = strtolower(end($file_parts));
        
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($file_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size <= 20 * 1024 * 1024) {
                    // Create uploads directory with proper path
                    $upload_dir = '../assets/uploads';
                    if (!is_dir($upload_dir)) {
                        // Try to create directory with full permissions
                        if (!mkdir($upload_dir, 0777, true)) {
                            $error = 'Failed to create uploads directory.';
                            error_log("Failed to create upload directory: $upload_dir");
                        }
                    }

                    $file_name_new = 'car_' . uniqid('', true) . '.' . $file_ext;
                    $file_destination = $upload_dir . '/' . $file_name_new;

                    if (move_uploaded_file($file_tmp_name, $file_destination)) {
                        $image_path = '../assets/uploads/' . $file_name_new;
                    } else {
                        $error = 'File upload failed. Check permissions for the uploads directory.';
                        error_log("Failed to move uploaded file to: $file_destination");
                    }
                } else {
                    $error = 'Your file is too large!';
                }
            } else {
                $error = 'There was an error uploading your file!';
            }
        } else {
            $error = 'You cannot upload files of this type!';
        }
    }

    // Validate inputs
    if (!validate_name($name)) {
        $error = 'Name must be at least 2 characters and contain only letters and spaces.';
    } elseif (!validate_car($type)) {
        $error = 'Type must be a valid car type.';
    } elseif (!validate_daily_rate($price)) {
        $error = 'Please enter a valid price.';
    } elseif (!validate_license_plate($license)) {
        $error = 'License plate must be between 5 and 20 characters and contain only letters and numbers.';
    } elseif (!validate_car_status($status)) {
        $error = 'Please select a valid status.';
    } elseif (!validate_year($year)) {
        $error = 'Year must be a valid 4-digit year.';
    } elseif (!validate_car($make)) {
        $error = 'Make must be a valid car make.';
    } elseif (!validate_car_model($model)) {
        $error = 'Model must be a valid car model.';
    } elseif (!validate_car($color)) {
        $error = 'Color must be a valid color.';
    } elseif (!validate_seats($seats)) {
        $error = 'Seats must be between 1 and 9.';
    } elseif (!validate_fuel_type($fuel_type)) {
        $error = 'Fuel type must be valid.';
    } elseif (!validate_features($features)) {
        $error = 'Features can be empty or contain actual content.';
    } else {
        try {
            // Create CarQueries instance
            $carQueries = new CarQueries($pdo);

            // Create new car
            $result = $carQueries->createCar(
                $name,
                $type,
                $description,
                $price,
                $image_path ?? '../assets/img/default-car.webp',
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
                    $_SESSION['register_success'] = 'Car added successfully!';
                    error_log("Successful car registration: {$license}");
                    redirect('../admin/manage-cars.php');
                    exit;
                } else {
                    // Registration failed
                    $error = 'Registration failed. Please try again.';
                    error_log("Registration failed for: {$license}");
                }
            }catch (Exception $e) {
            // Handle any unexpected errors
            $error = 'An unexpected error occurred: ' . $e->getMessage();
            error_log("Registration error: " . $e->getMessage());
        }
    }
    
    // If registration fails, store error in session and redirect back
    if (!empty($error)) {
        $_SESSION['register_error'] = $error;
        redirect('../admin/manage-cars.php');
    }
}
?>