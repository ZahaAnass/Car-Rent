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
    if(isset($_POST["add_car"])){
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
        
        $image_path = 'assets/img/default-car.webp'; // Default image path
        
        // Handle car image upload
        if (!empty($image['name'])) {
            $file_name = $image['name'];
            $file_type = $image['type'];
            $file_size = $image['size'];
            $file_error = $image['error'];
            $file_tmp_name = $image['tmp_name'];

            // Get file extension
            $file_parts = explode('.', $file_name);
            $file_ext = strtolower(end($file_parts));
            
            $allowed = ['jpg', 'jpeg', 'png', 'webp'];

            // More detailed error messages
            if ($file_error !== UPLOAD_ERR_OK) {
                $upload_errors = [
                    UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                    UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                    UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
                    UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                    UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
                ];
                
                $_SESSION['register_error'] = isset($upload_errors[$file_error]) 
                    ? $upload_errors[$file_error] 
                    : 'Unknown upload error occurred';
                redirect('../admin/manage-cars.php');
            }

            if (in_array($file_ext, $allowed)) {
                if ($file_size <= 20 * 1024 * 1024) { // 20MB limit
                    // Create uploads directory with proper path
                    $upload_dir = __DIR__ . '/../assets/uploads';
                    
                    // Ensure directory exists and is writable
                    if (!is_dir($upload_dir)) {
                        if (!mkdir($upload_dir, 0777, true)) {
                            $_SESSION['register_error'] = 'Failed to create uploads directory. Please check permissions.';
                            redirect('../admin/manage-cars.php');
                        }
                    }
                    
                    // Check if directory is writable
                    if (!is_writable($upload_dir)) {
                        $_SESSION['register_error'] = 'Upload directory is not writable. Please check permissions.';
                        redirect('../admin/manage-cars.php');
                    }

                    $file_name_new = 'car_' . uniqid('', true) . '.' . $file_ext;
                    $file_destination = $upload_dir . '/' . $file_name_new;
                    $relative_path = 'assets/uploads/' . $file_name_new; // Store relative path

                    // Try to move the uploaded file
                    if (move_uploaded_file($file_tmp_name, $file_destination)) {
                        // Change permissions to be readable by web server
                        chmod($file_destination, 0644);
                        $image_path = $relative_path;
                    } else {
                        $_SESSION['register_error'] = 'File upload failed. Please try again.';
                        redirect('../admin/manage-cars.php');
                    }
                } else {
                    $_SESSION['register_error'] = 'File size must be less than 20MB.';
                    redirect('../admin/manage-cars.php');
                }
            } else {
                $_SESSION['register_error'] = 'Only JPG, JPEG, PNG, and WEBP files are allowed.';
                redirect('../admin/manage-cars.php');
            }
        } else {
            // No image uploaded, use default
            $image_path = 'assets/img/default-car.webp';
        }

        // Validate inputs
        if (!validate_name($name)) {
            $_SESSION['register_error'] = 'Name must be at least 2 characters and contain only letters and spaces.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car($type)) {
            $_SESSION['register_error'] = 'Type must be a valid car type.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_daily_rate($price)) {
            $_SESSION['register_error'] = 'Please enter a valid price.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_license_plate($license)) {
            $_SESSION['register_error'] = 'License plate must be between 5 and 20 characters and contain only letters and numbers.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car_status($status)) {
            $_SESSION['register_error'] = 'Please select a valid status.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_year($year)) {
            $_SESSION['register_error'] = 'Year must be a valid 4-digit year.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car($make)) {
            $_SESSION['register_error'] = 'Make must be a valid car make.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car_model($model)) {
            $_SESSION['register_error'] = 'Model must be a valid car model.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car($color)) {
            $_SESSION['register_error'] = 'Color must be a valid color.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_seats($seats)) {
            $_SESSION['register_error'] = 'Seats must be between 1 and 9.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_fuel_type($fuel_type)) {
            $_SESSION['register_error'] = 'Fuel type must be valid.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_features($features)) {
            $_SESSION['register_error'] = 'Features can be empty or contain actual content.';
            redirect('../admin/manage-cars.php');
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
                    $image_path ?? 'assets/img/default-car.webp',
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
                        $_SESSION['register_error'] = 'License number is already registered.';
                    }
                    elseif ($result) { 
                        // Registration successful
                        $_SESSION['register_success'] = 'Car added successfully!';
                        redirect('../admin/manage-cars.php');
                        exit;
                    } else {
                        // Registration failed
                        $_SESSION['register_error'] = 'Registration failed. Please try again.';
                    }
                }catch (Exception $e) {
                // Handle any unexpected errors
                $_SESSION['register_error'] = 'An unexpected error occurred: ' . $e->getMessage();
            }
        }
        // If registration fails, store error in session and redirect back
        if (!empty($_SESSION['register_error'])) {
            redirect('../admin/manage-cars.php');
        }
    }elseif(isset($_POST["edit_car"])){
        // Sanitize inputs
        $car_id = trim(filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_NUMBER_INT));
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $type = trim(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $price = trim(filter_input(INPUT_POST, 'daily_rate', FILTER_SANITIZE_FULL_SPECIAL_CHARS)); 
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

        // Validate inputs
        if (!validate_name($name)) {
            $_SESSION['register_error'] = 'Name must be at least 2 characters and contain only letters and spaces.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car($type)) {
            $_SESSION['register_error'] = 'Type must be a valid car type.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_daily_rate($price)) {
            $_SESSION['register_error'] = 'Please enter a valid price.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_license_plate($license)) {
            $_SESSION['register_error'] = 'License plate must be between 5 and 20 characters and contain only letters and numbers.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car_status($status)) {
            $_SESSION['register_error'] = 'Please select a valid status.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_year($year)) {
            $_SESSION['register_error'] = 'Year must be a valid 4-digit year.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car($make)) {
            $_SESSION['register_error'] = 'Make must be a valid car make.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car_model($model)) {
            $_SESSION['register_error'] = 'Model must be a valid car model.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_car($color)) {
            $_SESSION['register_error'] = 'Color must be a valid color.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_seats($seats)) {
            $_SESSION['register_error'] = 'Seats must be between 1 and 9.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_fuel_type($fuel_type)) {
            $_SESSION['register_error'] = 'Fuel type must be valid.';
            redirect('../admin/manage-cars.php');
        } elseif (!validate_features($features)) {
            $_SESSION['register_error'] = 'Features can be empty or contain actual content.';
            redirect('../admin/manage-cars.php');
        } else {
            try {
                // Create CarQueries Object
                $carQueries = new CarQueries($pdo);
                // Update car details
                $result = $carQueries->updateCar(
                    $car_id,
                    $name,
                    $type,
                    $description ?? "No description available",
                    $price,
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

                if ($result) {
                    $_SESSION['register_success'] = 'Car updated successfully!';
                    redirect('../admin/manage-cars.php');
                    exit;
                } else {
                    $error = 'Update failed. Please try again.';
                }
            } catch (Exception $e) {
                $error = 'An unexpected error occurred: ' . $e->getMessage();
            }
        }
        // If update fails, store error in session and redirect back
        if (!empty($error)) {
            $_SESSION['register_error'] = $error;
            redirect('../admin/manage-cars.php');
        }
    }elseif(isset($_POST['delete_car'])){
        $car_id = trim(filter_input(INPUT_POST, 'car_id', FILTER_SANITIZE_NUMBER_INT));
        try {
            $carQueries = new CarQueries($pdo);
            $result = $carQueries->deleteCar($car_id);
            if ($result) {
                $_SESSION['register_success'] = 'Car deleted successfully!';
                redirect('../admin/manage-cars.php');
                exit;
            } else {
                $_SESSION['register_error'] = 'Delete failed. Please try again.';
            }
        } catch (Exception $e) {
            $_SESSION['register_error'] = 'An unexpected error occurred: ' . $e->getMessage();
        }
        if (!empty($_SESSION['register_error'])) {
            redirect('../admin/manage-cars.php');
        }
    }
    redirect('../admin/manage-cars.php');
}
?>