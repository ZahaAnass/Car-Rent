<?php
    require_once "../includes/session.php";
    start_session();
    require_once "../config/database.php";
    require_once "../includes/functions.php";
    require_once "../includes/queries/car_queries.php";
    require_once "../includes/queries/booking_queries.php";
    $carQueries = new CarQueries($pdo);
    $selected_car_id = isset($_GET['car_id']) ? filter_var($_GET['car_id'], FILTER_VALIDATE_INT) : null;
    $car = $carQueries->getCarById($selected_car_id);
    $user_id = $_SESSION['user_id'];
    if(!$car || ( $car['status'] !== 'Available' && $car['status'] !== 'Rented' )) {
        $_SESSION['booking_error'] = "Car not found.";
        redirect("../public/cars.php");
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pickup_date = trim(filter_input(INPUT_POST, 'pickup_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $return_date = trim(filter_input(INPUT_POST, 'return_date', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $pickup_location = trim(filter_input(INPUT_POST, 'pickup_location', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $return_location = trim(filter_input(INPUT_POST, 'return_location', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $daily_rate = trim(filter_input(INPUT_POST, 'daily_rate', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $total_price = trim(filter_input(INPUT_POST, 'total_price', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        if(!$pickup_date || !$return_date) {
            $_SESSION['booking_error'] = "Invalid date format. Please use YYYY-MM-DD.";
            redirect("../user/book-car.php?car_id=" . $selected_car_id);
        }elseif(!validate_date($pickup_date) || !validate_date($return_date)){
            $_SESSION['booking_error'] = "Invalid date format. Please use YYYY-MM-DD.";
            redirect("../user/book-car.php?car_id=" . $selected_car_id);
        }elseif($pickup_date >= $return_date) {
            $_SESSION['booking_error'] = "Pickup date must be before return date.";
            redirect("../user/book-car.php?car_id=" . $selected_car_id);
        }elseif(!$total_price) {
            $_SESSION['booking_error'] = "Invalid price format. Please use a valid price.";
            redirect("../user/book-car.php?car_id=" . $selected_car_id);
        }else{
            try {
                $bookingQueries = new BookingQueries($pdo);
                $isAvailable = $bookingQueries->checkCarAvailability($selected_car_id, $pickup_date, $return_date);
                if(!$isAvailable) {
                    $_SESSION['booking_error'] = "Car is not available for the selected dates.";
                    redirect("../user/book-car.php?car_id=" . $selected_car_id);
                }
                $result = $bookingQueries->createBooking($user_id, $selected_car_id, $pickup_date, $return_date, $pickup_location, $return_location, $total_price);
                if ($result) {
                    $_SESSION['booking_success'] = 'Booking added successfully!';
                    redirect('../user/book-car.php?car_id=' . $selected_car_id);
                } else {
                    $error = 'Add failed. Please try again.';
                }
            } catch (Exception $e) {
                $error = 'An unexpected error occurred: ' . $e->getMessage();
            }
        }
    }
    if (!empty($error)) {
        $_SESSION['booking_error'] = $error;
        redirect('../user/book-car.php?car_id=' . $selected_car_id);
    }

?>